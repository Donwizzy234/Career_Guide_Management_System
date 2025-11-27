<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $career_name = trim($_POST['career_name']);
    $desc = trim($_POST['description']);
    $stmt = $conn->prepare("INSERT INTO careers (career_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $career_name, $desc);
    if ($stmt->execute()) $msg = "Career added.";
    else $msg = "Error: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Manage Careers</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Manage Careers</h2>
<?php if($msg) echo "<p class='note'>$msg</p>"; ?>
<form method="post">
    <label>Career Name</label><br><input type="text" name="career_name" required><br>
    <label>Description</label><br><textarea name="description"></textarea><br>
    <input type="submit" value="Add Career">
</form>

<h3>Existing Careers</h3>
<ul>
<?php
    $res = $conn->query("SELECT * FROM careers ORDER BY career_name");
    while ($r = $res->fetch_assoc()) {
    echo "<li>".htmlspecialchars($r['career_name'])." — ".htmlspecialchars($r['description'])."</li>";
    }
?>
</ul>

<p><a href="admin_dashboard.php">Back</a></p>
</body>
</html>
