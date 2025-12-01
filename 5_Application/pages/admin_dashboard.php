<?php
session_start();
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <h1>Admin Dashboard</h1>
    <p id="title">Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']); ?></p>
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
        <ul id="capsule" class="stats-grid">
            <?php
            $c1 = (int)$conn->query("SELECT COUNT(*) as cnt FROM students")->fetch_assoc()['cnt'];
            $c2 = (int)$conn->query("SELECT COUNT(*) as cnt FROM careers")->fetch_assoc()['cnt'];
            $c3 = (int)$conn->query("SELECT COUNT(*) as cnt FROM questions")->fetch_assoc()['cnt'];

            $stats = [
                ['label' => 'Students', 'count' => $c1, 'icon' => '🎓', 'desc' => 'Registered learners'],
                ['label' => 'Careers',  'count' => $c2, 'icon' => '💼', 'desc' => 'Available career options'],
                ['label' => 'Questions', 'count' => $c3, 'icon' => '❓', 'desc' => 'Quizing Quetions'],
            ];

            foreach ($stats as $s) {
                echo '<li>';
                echo     '<span class="stat-icon">' . htmlspecialchars($s['icon']) . '</span>';
                echo     '<div class="stat-value">' . htmlspecialchars((string)$s['count']) . '</div>';
                echo     '<div class="stat-label">' . htmlspecialchars($s['label']) . '</div>';
                echo     '<div class="stat-desc">' . htmlspecialchars($s['desc']) . '</div>';
                echo '</li>';
            }
            ?>
        </ul>

    </section>
    <p><a href="student_logout.php" class="btn btn-danger">Logout</a></p>
</body>

</html>