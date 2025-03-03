<?php
include_once("asset/db_connection.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']); // Ensure it's an integer
    $status = trim($_POST['status']);

    // Validate allowed statuses to prevent arbitrary updates
    $allowed_statuses = ['Pending', 'Completed', 'Cancelled', 'Rented', 'Return', 'Laundry'];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status selection.");
    }

    // Update order status in the database
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        echo "success"; // Response for AJAX
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
