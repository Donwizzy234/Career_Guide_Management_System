<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Questions</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Questions & Options</h2>
<p><a href="create_questions.php">Add Question</a> | <a href="create_options.php">Add Option</a></p>
<?php
    $qres = $conn->query("SELECT * FROM questions ORDER BY question_id");
    while ($q = $qres->fetch_assoc()) {
    echo "<div class='question-block'>";
    echo "<h4>Q{$q['question_id']}: ".htmlspecialchars($q['question_text'])." ";
    echo "<a href='edit_question.php?id={$q['question_id']}'>[Edit]</a> ";
    echo "<a href='delete_question.php?id={$q['question_id']}' onclick=\"return confirm('Delete this question and its options?');\">[Delete]</a>";
    echo "</h4>";
    $ores = $conn->prepare("SELECT o.option_id, o.option_text, o.score, c.career_name FROM options o JOIN careers c ON o.career_id=c.career_id WHERE question_id = ? ORDER BY o.option_id");
    $ores->bind_param("i", $q['question_id']);
    $ores->execute();
    $orr = $ores->get_result();
    echo "<ul>";
    while ($op = $orr->fetch_assoc()) {
        echo "<li>".htmlspecialchars($op['option_text'])." — career: ".htmlspecialchars($op['career_name'])." (score: {$op['score']}) ";
        echo "<a href='edit_option.php?id={$op['option_id']}'>[Edit]</a> ";
        echo "<a href='delete_option.php?id={$op['option_id']}' onclick=\"return confirm('Delete this option?');\">[Delete]</a>";
        echo "</li>";
    }
    echo "</ul></div>";
    }
?>
<p><a href="../pages/admin_dashboard.php">Back</a></p>
</body>
</html>
