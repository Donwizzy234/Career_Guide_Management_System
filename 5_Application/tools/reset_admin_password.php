<?php
/**
 * CLI helper: reset an admin user's password safely from the command line.
 * Usage (from project root or this directory):
 *   php reset_admin_password.php <username> <new_password>
 *
 * Notes:
 * - This script is CLI-only (not web-accessible).
 * - It uses the same DB credentials as `db_connect.php`.
 */

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script must be run from the command line (CLI)\n");
    exit(1);
}

$argc_required = 3;
if ($argc < $argc_required) {
    fwrite(STDOUT, "Usage: php reset_admin_password.php <username> <new_password>\n");
    exit(1);
}

$username = $argv[1];
$newPassword = $argv[2];

require_once __DIR__ . '/../includes/db_connect.php';

if (!isset($conn) || !$conn) {
    fwrite(STDERR, "Database connection not available. Check db_connect.php.\n");
    exit(1);
}

$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE admins SET password_hash = ? WHERE username = ?");
if (!$stmt) {
    fwrite(STDERR, "Prepare failed: " . $conn->error . "\n");
    exit(1);
}

$stmt->bind_param('ss', $newHash, $username);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    fwrite(STDOUT, "Password reset successful for user '{$username}'.\n");
    $stmt->close();
    $conn->close();
    exit(0);
} else {
    fwrite(STDOUT, "No rows updated. The user '{$username}' may not exist.\n");
    $stmt->close();
    $conn->close();
    exit(2);
}

?>
