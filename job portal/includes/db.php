<?php
// Database credentials
$servername = "localhost"; // Usually 'localhost' if you're working on a local server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave blank if none for local server)
$dbname = "job_portal"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
