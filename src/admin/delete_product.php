<?php
// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get Product ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $delete_sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Product deleted successfully!'); window.location='show_all_product.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
