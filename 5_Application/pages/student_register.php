<?php
// student_register.php - self registration
session_start();
require_once '../includes/db_connect.php';
$err = $msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'] ?? '';
    $interest = trim($_POST['interest']);
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $err = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $err = "Password must be at least 6 characters.";
    } else {
        $stmt = $conn->prepare("SELECT student_id FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $err = "An account with that email already exists. Please login.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO students (full_name, email, gender, interest_area, password_hash) VALUES (?, ?, ?, ?, ?)");
            $ins->bind_param("sssss", $name, $email, $gender, $interest, $hash);
            if ($ins->execute()) {
                $msg = "Account created successfully. You can now login.";
            } else {
                $err = "Error: " . $ins->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Student Register</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<h2>Create Student Account</h2>
<?php if($err) echo "<p class='error'>$err</p>"; ?>
<?php if($msg) echo "<p class='note'>$msg</p>"; ?>
<form method="post" action="">
    <label>Full Name</label><br><input type="text" name="full_name" required><br>
    <label>Email</label><br><input type="email" name="email" required><br>
    <label>Password</label><br><input type="password" name="password" required><br>
    <label>Confirm Password</label><br><input type="password" name="confirm_password" required><br>
    <label>Gender</label><br>
    <select name="gender" required>
    <option value="">--Select--</option>
    <option>Male</option>
    <option>Female</option>
    </select><br>
    <label>Interest Area</label><br><input type="text" name="interest" required><br>
    <input type="submit" value="Create Account">
</form>
<p><a href="student_login.php">Already have an account? Login</a></p>
</body>
</html>
