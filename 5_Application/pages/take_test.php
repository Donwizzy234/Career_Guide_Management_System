<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';

// load questions & options
$questions = [];
$qres = $conn->query("SELECT question_id, question_text FROM questions ORDER BY question_id");
while ($qrow = $qres->fetch_assoc()) {
    $qid = $qrow['question_id'];
    $opts = [];
    $ores = $conn->prepare("SELECT option_id, option_text FROM options WHERE question_id = ? ORDER BY option_id");
    $ores->bind_param("i", $qid);
    $ores->execute();
    $orr = $ores->get_result();
    while ($orow = $orr->fetch_assoc()) $opts[] = $orow;
    $questions[] = ['q'=>$qrow, 'options'=>$opts];
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Take Test</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Psychometric Test</h2>
<form method="post" action="process_test.php">
    <?php foreach ($questions as $i => $item): ?>
    <div class="question-block">
        <p><strong>Q<?php echo $i+1; ?>.</strong> <?php echo htmlspecialchars($item['q']['question_text']); ?></p>
        <?php foreach ($item['options'] as $opt): ?>
        <label>
            <input type="radio" name="q<?php echo $item['q']['question_id']; ?>" value="<?php echo $opt['option_id']; ?>" required>
            <?php echo htmlspecialchars($opt['option_text']); ?>
        </label><br>
        <?php endforeach; ?>
    </div>
    <hr>
    <?php endforeach; ?>
    <input type="submit" value="Submit Test">
</form>
<p><a href="student_dashboard.php">Back</a></p>
</body>
</html>
