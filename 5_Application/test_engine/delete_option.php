<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list_questions.php'); exit;
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM options WHERE option_id = ?");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    $stmt->close();
    header('Location: list_questions.php?msg=' . urlencode('Option deleted.'));
    exit;
} else {
    $err = $stmt->error;
    $stmt->close();
    header('Location: list_questions.php?msg=' . urlencode('Error deleting option: ' . $err));
    exit;
}

?>
