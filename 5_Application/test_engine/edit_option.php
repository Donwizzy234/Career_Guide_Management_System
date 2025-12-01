<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';

$msg = '';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list_questions.php'); exit;
}
$id = (int)$_GET['id'];

// fetch option
$s = $conn->prepare("SELECT option_id, question_id, option_text, career_id, score FROM options WHERE option_id = ?");
$s->bind_param('i', $id);
$s->execute();
$res = $s->get_result();
if ($res->num_rows === 0) { header('Location: list_questions.php?msg=' . urlencode('Option not found.')); exit; }
$opt = $res->fetch_assoc();
$s->close();

// fetch careers and questions for dropdowns
$careers = $conn->query("SELECT career_id, career_name FROM careers ORDER BY career_name")->fetch_all(MYSQLI_ASSOC);
$questions = $conn->query("SELECT question_id, question_text FROM questions ORDER BY question_id")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $optText = trim($_POST['option_text'] ?? '');
    $careerId = (int)($_POST['career_id'] ?? 0);
    $questionId = (int)($_POST['question_id'] ?? $opt['question_id']);
    $score = (int)($_POST['score'] ?? 1);
    if ($optText === '' || $careerId <= 0) $msg = 'Option text and career are required.';
    else {
        $u = $conn->prepare("UPDATE options SET question_id = ?, option_text = ?, career_id = ?, score = ? WHERE option_id = ?");
        $u->bind_param('isiii', $questionId, $optText, $careerId, $score, $id);
        if ($u->execute()) { $u->close(); header('Location: list_questions.php?msg=' . urlencode('Option updated.')); exit; }
        else { $msg = 'Error: ' . $u->error; $u->close(); }
    }
}

?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Edit Option</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Edit Option</h2>
<?php if($msg) echo "<p class='note'>".htmlspecialchars($msg)."</p>"; ?>
<form method="post">
    <label>Question</label><br>
    <select name="question_id" required>
    <?php foreach($questions as $q) {
        $sel = ($q['question_id']==$opt['question_id'])? 'selected':'';
        echo "<option value='{$q['question_id']}' $sel>".htmlspecialchars($q['question_text'])."</option>";
    } ?>
    </select><br>

    <label>Option Text</label><br>
    <input type="text" name="option_text" value="<?php echo htmlspecialchars($opt['option_text']); ?>" required><br>

    <label>Maps to Career</label><br>
    <select name="career_id" required>
    <?php foreach($careers as $c) {
        $sel = ($c['career_id']==$opt['career_id'])? 'selected':'';
        echo "<option value='{$c['career_id']}' $sel>".htmlspecialchars($c['career_name'])."</option>";
    } ?>
    </select><br>

    <label>Score</label><br>
    <input type="number" name="score" value="<?php echo htmlspecialchars($opt['score']); ?>" required><br>

    <input type="submit" value="Save">
    <a href="list_questions.php">Cancel</a>
</form>
</body>
</html>
