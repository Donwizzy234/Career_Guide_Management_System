<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Career Report</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <h2>Career Summary Report</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Career Name</th>
            <th>Description</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM careers ORDER BY career_name");
        while ($r = $res->fetch_assoc()) {
            echo "<tr><td>{$r['career_id']}</td><td>" . htmlspecialchars($r['career_name']) . "</td><td>" . htmlspecialchars($r['description']) . "</td></tr>";
        }
        ?>
    </table>
    <p><a href="../pages/admin_dashboard.php" class="btn btn-danger">Back</a></p>
</body>

</html>