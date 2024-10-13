<?php
// db.php: Database connection
$host = "localhost";
$user = "root";
$password = "Zihan";
$dbname = "campus_db";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
