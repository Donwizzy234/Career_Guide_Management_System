<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';
$student_name = $_SESSION['student_name'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <h1>Welcome, <?php echo htmlspecialchars($student_name); ?></h1>
    <nav>
        <ul>
            <li><a href="take_test.php">Take Psychometric Test</a></li>
            <li><a href="view_my_result.php">View My Result</a></li>
            <li><a href="update_profile.php">Edit Profile</a></li>
        </ul>
    </nav>
    <section>
        <h2>Available Careers</h2>
        <ul id="capsule">
            <?php
            $res = $conn->query("SELECT career_name FROM careers ORDER BY career_name");
            while ($r = $res->fetch_assoc()) {
                echo "<li>";
                echo "<div class='career-name'>" . htmlspecialchars($r['career_name']) . "</div>";
                echo "<p class='career-desc'>Explore this exciting career path and discover your potential.</p>";
                echo "</li>";
            }
            ?>
        </ul>
    </section>
    <p><a href="student_logout.php" class="btn btn-danger">Logout</a></p>
</body>

</html>