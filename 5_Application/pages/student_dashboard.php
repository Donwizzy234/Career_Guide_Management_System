<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';
$student_name = $_SESSION['student_name'];
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Student Dashboard</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h1>Welcome, <?php echo htmlspecialchars($student_name); ?></h1>
<p><a href="student_logout.php">Logout</a></p>
<nav>
    <ul>
    <li><a href="take_test.php">Take Psychometric Test</a></li>
    <li><a href="view_my_result.php">View My Result</a></li>
    <li><a href="update_profile.php">Edit Profile</a></li>
    </ul>
 </nav>
<section>
    <h2>Available Careers</h2>
    <ul>
    <?php
    $res = $conn->query("SELECT career_name FROM careers ORDER BY career_name");
    while ($r = $res->fetch_assoc()) echo "<li>".htmlspecialchars($r['career_name'])."</li>";
    ?>
    </ul>
</section>
</body>
</html>
