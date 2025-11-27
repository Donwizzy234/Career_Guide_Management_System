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
    <li><a href="student_register.php">Create Account</a></li>
    <li><a href="student_login.php">Student Login</a></li>
    <!-- <li><a href="admin_login.php">Admin Login</a></li> -->
    </ul>
 </nav>
<p style="text-align:center">Create an account, login and take the psychometric test.</p>
</body>
</html>
