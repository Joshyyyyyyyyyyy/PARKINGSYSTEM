<?php
$servername = "localhost";
$username = "root";  // Adjust if using a different MySQL user
$password = "";      // Adjust based on your MySQL password
$dbname = "database1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
