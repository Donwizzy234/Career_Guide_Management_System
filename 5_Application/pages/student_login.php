<?php
// student_login.php
session_start();
require_once '../includes/db_connect.php';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT student_id, full_name, password_hash FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (!empty($row['password_hash']) && password_verify($password, $row['password_hash'])) {
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['student_name'] = $row['full_name'];
            header("Location: student_dashboard.php");
            exit;
        } else {
            $err = "Invalid email or password.";
        }
    } else {
        $err = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <h2>Student Login</h2>
    <?php if ($err) echo "<p class='error'>$err</p>"; ?>
    <form method="post">
        <label>Email</label><br><input type="email" name="email" required><br>
        <label>Password</label><br><input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <p><a href="index.php" class="btn">Home</a>
        <a href="student_register.php" class="btn">Create account</a>

    </p>
</body>

</html>