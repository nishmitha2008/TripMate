
<?php
$host = "localhost";
$port = 3306;
$username = "root";
$password = "";
$database = "tripmate_db";

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

