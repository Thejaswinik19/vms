<?php
$host = "localhost";      // Database host (e.g., localhost)
$user = "root";           // Database username
$pass = "";               // Database password (default is empty for XAMPP)
$dbname = "vehicle_database";   // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
