<?php
// index.php - landing page
session_start();
if (isset($_SESSION['admin_id'])) header("Location: admin_dashboard.php");
if (isset($_SESSION['student_id'])) header("Location: student_dashboard.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Career Guide System</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>


<body>
    <h1>Career Guide / Psychometric System</h1>
    <nav>
        <ul>
            <li><a href="student_register.php" class="btn">Create Account</a></li>
            <li><a href="student_login.php" class="btn">Student Login</a></li>
            <li><a href="admin_login.php" class="btn">Admin Login</a></li>
        </ul>
    </nav>
    <p style="text-align:center">Stressed about Your Tomorrow, Take Your Career Test Today</p>
</body>

</html>