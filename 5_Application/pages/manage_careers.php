<?php
require_once '../security/auth_admin.php';
require_once '../includes/db_connect.php';
$msg = '';

// Show one-time flash message if present
if (isset($_SESSION['flash'])) {
    $msg = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

// Initialize form variables
$edit_id = 0;
$career_name = '';
$desc = '';
$submit_label = 'Add Career';

// Handle delete via POST (safer than GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $del_id = (int) $_POST['delete_id'];
    if ($del_id > 0) {
        $stmt = $conn->prepare("DELETE FROM careers WHERE career_id = ?");
        $stmt->bind_param("i", $del_id);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['flash'] = 'Career deleted.';
            header('Location: manage_careers.php');
            exit;
        } else {
            $msg = 'Error deleting career: ' . $stmt->error;
        }
    }
}

// Load career for editing via GET
if (isset($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    if ($edit_id > 0) {
        $stmt = $conn->prepare("SELECT career_name, description FROM careers WHERE career_id = ?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $stmt->bind_result($career_name, $desc);
        if (!$stmt->fetch()) {
            $msg = 'Career not found.';
            $career_name = '';
            $desc = '';
            $edit_id = 0;
        } else {
            $submit_label = 'Update Career';
        }
        $stmt->close();
    }
}

// Handle create/update via POST (skip if delete handled above)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_id'])) {
    $career_name = trim($_POST['career_name']);
    $desc = trim($_POST['description']);
    if (!empty($_POST['id']) && (int)$_POST['id'] > 0) {
        // Update existing career
        $id = (int) $_POST['id'];
        $stmt = $conn->prepare("UPDATE careers SET career_name = ?, description = ? WHERE career_id = ?");
        $stmt->bind_param("ssi", $career_name, $desc, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['flash'] = "Career updated.";
            header('Location: manage_careers.php');
            exit;
        } else {
            $msg = "Error: " . $stmt->error;
        }
    } else {
        // Insert new career
        $stmt = $conn->prepare("INSERT INTO careers (career_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $career_name, $desc);
        if ($stmt->execute()) {
            $stmt->close();
            $_SESSION['flash'] = "Career added.";
            header('Location: manage_careers.php');
            exit;
        } else {
            $msg = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Manage Careers</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<h2>Manage Careers</h2>
<?php if($msg) echo "<p class='note'>$msg</p>"; ?>
<form method="post">
    <input type="hidden" name="id" value="<?php echo (int)$edit_id; ?>">
    <label>Career Name</label><br>
    <input type="text" name="career_name" required value="<?php echo htmlspecialchars($career_name); ?>"><br>
    <label>Description</label><br>
    <textarea name="description"><?php echo htmlspecialchars($desc); ?></textarea><br>
    <input type="submit" value="<?php echo $submit_label; ?>">
    <?php if ($edit_id): ?><a href="manage_careers.php">Cancel</a><?php endif; ?>
</form>

<h3>Existing Careers</h3>
<ul>
<?php
    $res = $conn->query("SELECT * FROM careers ORDER BY career_name");
    while ($r = $res->fetch_assoc()) {
        $id = (int)$r['career_id'];
        $name = htmlspecialchars($r['career_name']);
        $description = htmlspecialchars($r['description']);
        echo "<li>$name — $description ";
        echo "<a href='?edit=$id'>Edit</a> ";
        // Delete via POST form to avoid GET side-effects
        echo "<form method='post' style='display:inline;margin:0;padding:0;' onsubmit=\"return confirm('Are you sure you want to delete this career?');\">";
        echo "<input type='hidden' name='delete_id' value='$id'>";
        echo "<button type='submit' style='background:none;border:none;color:#00f;text-decoration:underline;cursor:pointer;padding:0;margin-left:6px;'>Delete</button>";
        echo "</form>";
        echo "</li>";
    }
?>
</ul>

<p><a href="admin_dashboard.php">Back</a></p>
</body>
</html>
