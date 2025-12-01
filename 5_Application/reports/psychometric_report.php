<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Psychometric Report</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 500px;
            max-width: 98vw;
            margin: 30px auto;
            height: 500px;
            position: relative;
        }
    </style>
</head>

<body>
    <h2>Psychometric Distribution Report</h2>
    <div class="chart-container">
        <canvas id="careerPie"></canvas>
    </div>
    <table>
        <tr>
            <th>Career</th>
            <th>Number of Students</th>
            <th>Average Score</th>
        </tr>
        <?php
        $sql = "SELECT c.career_name,
                COUNT(DISTINCT s.student_id) AS num_students,
                AVG(s.score) AS avg_score
            FROM careers c
            LEFT JOIN student_scores s ON c.career_id = s.career_id
            GROUP BY c.career_id
            ORDER BY num_students DESC";
        $res = $conn->query($sql);

        // Prepare data for chart
        $career_names = [];
        $student_counts = [];
        while ($r = $res->fetch_assoc()) {
            $career_names[] = $r['career_name'];
            $student_counts[] = (int)$r['num_students'];
            echo "<tr><td>" . htmlspecialchars($r['career_name']) . "</td><td>{$r['num_students']}</td><td>" . (is_null($r['avg_score']) ? '0' : round($r['avg_score'], 2)) . "</td></tr>";
        }
        ?>
    </table>
    <p><a href="../pages/admin_dashboard.php" class="btn btn-danger">Back</a></p>
    <script>
        const ctx = document.getElementById('careerPie').getContext('2d');
        const careerPie = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($career_names); ?>,
                datasets: [{
                    label: 'Number of Students',
                    data: <?php echo json_encode($student_counts); ?>,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                        '#7ED957', '#F67280', '#355C7D', '#B5FFFC', '#F8B195', '#C06C84'
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
                        text: 'Student Distribution by Career'
                    }
                }
            }
        });
    </script>
</body>

</html>