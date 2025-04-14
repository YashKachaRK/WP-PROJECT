<?php
// delete_user.php

// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM users_register WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('User deleted successfully.');
                window.location.href = 'customer.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to delete user.');
                window.location.href = 'customer.php';
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = 'customer.php';
          </script>";
}

$conn->close();
?>
