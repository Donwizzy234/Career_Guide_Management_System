<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';
$student_id = $_SESSION['student_id'];

$stmt = $conn->prepare("SELECT c.career_id, c.career_name, COALESCE(SUM(s.score),0) AS total_score
                        FROM careers c
                        LEFT JOIN student_scores s ON c.career_id = s.career_id AND s.student_id = ?
                        GROUP BY c.career_id
                        ORDER BY total_score DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();
$rows = [];
while ($r = $res->fetch_assoc()) $rows[] = $r;

$best = null;
foreach ($rows as $r) {
    if ($best === null && (int)$r['total_score'] > 0) { $best = $r; }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>My Result</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Your Psychometric Result</h2>
<p>Student: <?php echo htmlspecialchars($_SESSION['student_name']); ?></p>
<table>
    <tr><th>Career</th><th>Total Score</th></tr>
    <?php foreach ($rows as $r): ?>
    <tr>
        <td><?php echo htmlspecialchars($r['career_name']); ?></td>
        <td><?php echo htmlspecialchars($r['total_score']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if ($best): ?>
    <h3>Recommended Career: <?php echo htmlspecialchars($best['career_name']); ?></h3>
<?php else: ?>
    <p>No recommendation yet — ensure you completed the test.</p>
<?php endif; ?>

<p><a href="student_dashboard.php">Back</a></p>
</body>
</html>
