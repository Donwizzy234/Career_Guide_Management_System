<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
$msg = '';

$questions = $conn->query("SELECT question_id, question_text FROM questions ORDER BY question_id")->fetch_all(MYSQLI_ASSOC);
$careers = $conn->query("SELECT career_id, career_name FROM careers ORDER BY career_name")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = (int)$_POST['question_id'];
    $option_text = trim($_POST['option_text']);
    $career_id = (int)$_POST['career_id'];
    $score = (int)$_POST['score'];

    $stmt = $conn->prepare("INSERT INTO options (question_id, option_text, career_id, score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $question_id, $option_text, $career_id, $score);
    if ($stmt->execute()) $msg = "Option added.";
    else $msg = "Error: " . $stmt->error;
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Create Option</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Create Option</h2>
<?php if($msg) echo "<p class='note'>$msg</p>"; ?>
<form method="post">
    <label>Question</label><br>
    <select name="question_id" required>
    <?php foreach($questions as $q) echo "<option value='". $q['question_id'] ."'>Q". $q['question_id'] .": ".htmlspecialchars($q['question_text'])."</option>"; ?>
    </select><br>

    <label>Option Text</label><br>
    <input type="text" name="option_text" required><br>

    <label>Maps to Career</label><br>
    <select name="career_id" required>
    <?php foreach($careers as $c) echo "<option value='{$c['career_id']}'>".htmlspecialchars($c['career_name'])."</option>"; ?>
    </select><br>

    <label>Score (integer)</label><br>
    <input type="number" name="score" value="1" required><br>

    <input type="submit" value="Add Option">
</form>

<p><a href="list_questions.php">Back to Questions</a></p>
</body>
</html>
