<?php
// admin_login.php
session_start();
require_once '../includes/db_connect.php';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT admin_id, password_hash FROM admins WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($admin_id, $password_hash);
            $stmt->fetch();
            if (password_verify($password, $password_hash)) {
                $_SESSION['admin_id'] = $admin_id;
                $_SESSION['admin_user'] = $username;
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $err = "Invalid credentials.";
            }
        } else {
            $err = "Invalid credentials.";
        }
        $stmt->close();
    } else {
        error_log("admin_login.php: prepare() failed: " . $conn->error);
        $err = "An internal error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8">
<title>Admin Login</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Admin Login</h2>
<?php if($err) echo "<p class='error'>$err</p>"; ?>
<form method="post">
    <label>Username</label><br><input type="text" name="username" required><br>
    <label>Password</label><br><input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>
