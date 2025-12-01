<?php
session_start();
require_once '../security/auth_student.php';
require_once '../includes/db_connect.php';
$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: take_test.php");
    exit;
}

// optional: remove previous scores for fresh attempt
$del = $conn->prepare("DELETE FROM student_scores WHERE student_id = ?");
$del->bind_param("i", $student_id);
$del->execute();

// insert option scores
foreach ($_POST as $field => $option_id) {
    if (strpos($field, 'q') !== 0) continue;
    $optId = (int)$option_id;
    $s = $conn->prepare("SELECT career_id, score FROM options WHERE option_id = ?");
    $s->bind_param("i", $optId);
    $s->execute();
    $res = $s->get_result();
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $career_id = (int)$row['career_id'];
        $score = (int)$row['score'];
        $ins = $conn->prepare("INSERT INTO student_scores (student_id, career_id, score) VALUES (?, ?, ?)");
        $ins->bind_param("iii", $student_id, $career_id, $score);
        $ins->execute();
    }
}

// redirect to results
header("Location: view_my_result.php");
exit;
