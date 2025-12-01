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
    if ($best === null && (int)$r['total_score'] > 0) {
        $best = $r;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>My Result</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .result-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .chart-container {
            position: relative;
            width: 500px;
            height: 500px;
        }

        .recommended-career-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .career-icon {
            font-size: 24px;
            color: #f77f99ff;
        }

        .career-title {
            font-size: 18px;
            color: #36A2EB;
        }
    </style>
</head>

<body>
    <p><a href="student_dashboard.php" class="btn btn-danger">Back</a></p>
    <h2>Your Psychometric Result</h2>

    <div class="student-info">
        <p>Welcome,</p>
        <span class="student-name"><?php echo htmlspecialchars($_SESSION['student_name']); ?></span>
    </div>

    <div class="result-container">
        <div class="chart-container">
            <canvas id="careerChart"></canvas>
        </div>
    </div>

    <?php if ($best): ?>
        <div class="recommended-career-card">
            <span class="career-icon">🌟</span>
            <div class="career-title">Recommended Career:</div>
            <div><?php echo htmlspecialchars($best['career_name']); ?></div>
        </div>
    <?php else: ?>
        <p>No recommendation yet — ensure you completed the test.</p>
    <?php endif; ?>

    <script>
        const ctx = document.getElementById('careerChart').getContext('2d');
        const careerChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    <?php foreach ($rows as $r): ?> '<?php echo htmlspecialchars($r['career_name']); ?>',
                    <?php endforeach; ?>
                ],
                datasets: [{
                    label: 'Career Scores',
                    data: [
                        <?php foreach ($rows as $r): ?>
                            <?php echo (int)$r['total_score']; ?>,
                        <?php endforeach; ?>
                    ],
                    backgroundColor: [
                        '#f77f99ff',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Your Career Scores'
                    }
                }
            }
        });
    </script>
</body>

</html>