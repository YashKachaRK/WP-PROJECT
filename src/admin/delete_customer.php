<?php
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

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete Query
    $delete_query = "DELETE FROM users_register WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Customer deleted successfully!');
                window.location.href='customer.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting customer!');
                window.location.href='customer.php';
              </script>";
    }

    $stmt->close();
}

// Close Connection
$conn->close();
?>
