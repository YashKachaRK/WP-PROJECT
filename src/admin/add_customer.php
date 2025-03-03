<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO users_register (full_name, email, phone, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $full_name, $email, $phone);

    if ($stmt->execute()) {
        echo "Customer added successfully!";
    } else {
        echo "Error adding customer!";
    }

    $stmt->close();
}

$conn->close();
?>
