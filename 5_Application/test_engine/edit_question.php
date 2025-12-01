<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';

$msg = '';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list_questions.php'); exit;
}
$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qtxt = trim($_POST['question_text'] ?? '');
    if ($qtxt === '') $msg = 'Question text cannot be empty.';
    else {
        $stmt = $conn->prepare("UPDATE questions SET question_text = ? WHERE question_id = ?");
        $stmt->bind_param('si', $qtxt, $id);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: list_questions.php?msg=' . urlencode('Question updated.')); exit;
        } else {
            $msg = 'Error: ' . $stmt->error;
            $stmt->close();
        }
    }
}

$row = $conn->prepare("SELECT question_text FROM questions WHERE question_id = ?");
$row->bind_param('i', $id);
$row->execute();
$res = $row->get_result();
if ($res->num_rows === 0) { header('Location: list_questions.php?msg=' . urlencode('Question not found.')); exit; }
$q = $res->fetch_assoc();
$row->close();

?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Edit Question</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Edit Question</h2>
<?php if($msg) echo "<p class='note'>".htmlspecialchars($msg)."</p>"; ?>
<form method="post">
    <label>Question Text</label><br>
    <textarea name="question_text" required><?php echo htmlspecialchars($q['question_text']); ?></textarea><br>
    <input type="submit" value="Save">
    <a href="list_questions.php">Cancel</a>
</form>
</body>
</html>
