<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Psychometric Report</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Psychometric Distribution Report</h2>
<table>
    <tr><th>Career</th><th>Number of Students</th><th>Average Score</th></tr>
    <?php
    $sql = "SELECT c.career_name,
                COUNT(DISTINCT s.student_id) AS num_students,
                AVG(s.score) AS avg_score
            FROM careers c
            LEFT JOIN student_scores s ON c.career_id = s.career_id
            GROUP BY c.career_id
            ORDER BY num_students DESC";
    $res = $conn->query($sql);
    while ($r = $res->fetch_assoc()) {
        echo "<tr><td>".htmlspecialchars($r['career_name'])."</td><td>{$r['num_students']}</td><td>".(is_null($r['avg_score']) ? '0' : round($r['avg_score'],2))."</td></tr>";
    }
    ?>
</table>
<p><a href="../pages/admin_dashboard.php">Back</a></p>
</body>
</html>
