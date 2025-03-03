<?php
$host = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";  // Change this if you have a different database username
$password = "";      // Change this if you have a database password
$database = "final"; // Change this to your actual database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
