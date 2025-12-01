<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qtxt = trim($_POST['question_text']);
    if ($qtxt !== '') {
        $stmt = $conn->prepare("INSERT INTO questions (question_text) VALUES (?)");
        $stmt->bind_param("s", $qtxt);
        if ($stmt->execute()) $msg = "Question added.";
        else $msg = "Error: " . $stmt->error;
    } else $msg = "Enter question text.";
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Create Question</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Create Question</h2>
<?php if($msg) echo "<p class='note'>$msg</p>"; ?>
<form method="post">
    <label>Question Text</label><br>
    <textarea name="question_text" required></textarea><br>
    <input type="submit" value="Add Question">
</form>
<p><a href="list_questions.php">Back to Questions</a></p>
</body>
</html>
