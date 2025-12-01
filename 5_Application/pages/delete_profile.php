<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';

$student_id = $_SESSION['student_id'];
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify password before deletion
    $password = $_POST['password'] ?? '';
    
    if (empty($password)) {
        $error = "Password is required to delete your profile.";
    } else {
        // Get current password hash
        $stmt = $conn->prepare("SELECT password_hash FROM students WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if (!$result || !password_verify($password, $result['password_hash'])) {
            $error = "Incorrect password. Profile was not deleted.";
        } else {
            // Delete student scores first (due to foreign key constraint)
            $del_scores = $conn->prepare("DELETE FROM student_scores WHERE student_id = ?");
            $del_scores->bind_param("i", $student_id);
            $del_scores->execute();
            
            // Delete student profile
            $del_student = $conn->prepare("DELETE FROM students WHERE student_id = ?");
            $del_student->bind_param("i", $student_id);
            
            if ($del_student->execute()) {
                $success = true;
                session_destroy();
            } else {
                $error = "Error deleting profile: " . $del_student->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Delete Profile</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<?php if ($success): ?>
    <h2>Profile Deleted Successfully</h2>
    <p>Your profile has been permanently deleted.</p>
    <p><a href="student_login.php">Return to Login</a></p>
<?php else: ?>
    <h2>Delete Profile</h2>
    <p style="color: red; font-weight: bold;">Warning: This action cannot be undone. Your profile and all associated data will be permanently deleted.</p>
    
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    
    <form method="post">
        <p>Enter your password to confirm deletion:</p>
        <label>Password</label><br>
        <input type="password" name="password" required><br>
        <hr>
        <input type="submit" value="Delete Profile Permanently" style="background-color: #d32f2f; color: white;">
        <input type="button" value="Cancel" onclick="history.back();">
    </form>
    <p><a href="student_dashboard.php">Back to Dashboard</a></p>
<?php endif; ?>
</body>
</html>
