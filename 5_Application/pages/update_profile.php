<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';
$student_id = $_SESSION['student_id'];
$err = $msg = '';

$stmt = $conn->prepare("SELECT full_name, email, gender, interest_area FROM students WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$cur = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'] ?? '';
    $interest = trim($_POST['interest']);
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $chk = $conn->prepare("SELECT student_id FROM students WHERE email = ? AND student_id != ?");
    $chk->bind_param("si", $email, $student_id);
    $chk->execute();
    if ($chk->get_result()->num_rows > 0) {
        $err = "Email already in use by another account.";
    } elseif ($password !== '' && $password !== $confirm) {
        $err = "Passwords do not match.";
    } else {
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $upd = $conn->prepare("UPDATE students SET full_name=?, email=?, gender=?, interest_area=?, password_hash=? WHERE student_id=?");
            $upd->bind_param("sssssi", $name, $email, $gender, $interest, $hash, $student_id);
        } else {
            $upd = $conn->prepare("UPDATE students SET full_name=?, email=?, gender=?, interest_area=? WHERE student_id=?");
            $upd->bind_param("ssssi", $name, $email, $gender, $interest, $student_id);
        }
        if ($upd->execute()) {
            $msg = "Profile updated.";
            $_SESSION['student_name'] = $name;
        } else $err = "Error: " . $upd->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Edit Profile</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Edit Profile</h2>
<?php if($err) echo "<p class='error'>$err</p>"; ?>
<?php if($msg) echo "<p class='note'>$msg</p>"; ?>

<form method="post">
    <label>Full Name</label><br><input type="text" name="full_name" value="<?php echo htmlspecialchars($cur['full_name']); ?>" required><br>
    <label>Email</label><br><input type="email" name="email" value="<?php echo htmlspecialchars($cur['email']); ?>" required><br>
    <label>Gender</label><br>
    <select name="gender">
    <option <?php if($cur['gender']=='Male') echo 'selected'; ?>>Male</option>
    <option <?php if($cur['gender']=='Female') echo 'selected'; ?>>Female</option>
    </select><br>
    <label>Interest Area</label><br><input type="text" name="interest" value="<?php echo htmlspecialchars($cur['interest_area']); ?>" required><br>
    <hr>
    <p>Leave password fields blank to keep current password.</p>
    <label>New Password</label><br><input type="password" name="password"><br>
    <label>Confirm New Password</label><br><input type="password" name="confirm_password"><br>

    <div style="display:flex; gap:10px; align-items:center; margin-top:8px;">
        <input type="submit" value="Update Profile">
        <button type="button" id="showDelBtn" style="color:#fff; background:#d32f2f; padding:8px 12px; border:none; border-radius:4px; cursor:pointer;">Delete Profile</button>
    </div>
</form>

<!-- Inline deletion form (hidden until user clicks Delete) -->
<form method="post" action="delete_profile.php" id="delForm" style="display:none; margin-top:12px; border:1px solid #f5c6cb; padding:12px; border-radius:6px; background:#fff6f6;">
    <p style="color:#d32f2f; font-weight:bold; margin:0 0 8px 0;">Warning: This action will permanently delete your profile.</p>
    <label for="del_password">Enter your password to confirm deletion</label><br>
    <input type="password" name="password" id="del_password" required style="margin-top:6px; padding:6px; width:260px;"><br>
    <div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
        <button type="submit" style="background:#d32f2f; color:#fff; padding:8px 12px; border:none; border-radius:4px;">Delete Profile Permanently</button>
        <button type="button" id="cancelDel" style="padding:8px 12px;">Cancel</button>
    </div>
</form>

<p>
    <a href="student_dashboard.php">Back</a>
</p>

<script>
    (function(){
        var showBtn = document.getElementById('showDelBtn');
        var delForm = document.getElementById('delForm');
        var cancel = document.getElementById('cancelDel');
        showBtn && showBtn.addEventListener('click', function(){
            delForm.style.display = 'block';
            window.scrollTo({ top: delForm.offsetTop - 20, behavior: 'smooth' });
            document.getElementById('del_password').focus();
        });
        cancel && cancel.addEventListener('click', function(){
            delForm.style.display = 'none';
        });
    })();
</script>
</body>
</html>
