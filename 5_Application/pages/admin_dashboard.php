<?php
session_start();
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Admin Dashboard</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h1>Admin Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?> | <a href="student_logout.php">Logout</a></p>
<nav>
    <ul>
    <li><a href="manage_careers.php">Manage Careers</a></li>
    <li><a href="../test_engine/list_questions.php">Manage Questions</a></li>
    <li><a href="../reports/career_report.php">Career Report</a></li>
    <li><a href="../reports/psychometric_report.php">Psychometric Report</a></li>
    </ul>
</nav>

<section>
    <h2>Quick stats</h2>
    <?php
    $c1 = $conn->query("SELECT COUNT(*) as cnt FROM students")->fetch_assoc()['cnt'];
    $c2 = $conn->query("SELECT COUNT(*) as cnt FROM careers")->fetch_assoc()['cnt'];
    $c3 = $conn->query("SELECT COUNT(*) as cnt FROM questions")->fetch_assoc()['cnt'];
    echo "<p>Students: $c1 | Careers: $c2 | Questions: $c3</p>";
    ?>
</section>
</body>
</html>
