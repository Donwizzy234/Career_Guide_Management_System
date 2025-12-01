<?php
// db_connect.php - update credentials if necessary
$host = "localhost";
$user = "root";
$pass = ""; // set your MySQL password
$dbname = "career_guide_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
