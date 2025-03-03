<?php
include 'asset/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $order_id = $_POST['order_id'];
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $alt_phone = $_POST['alt_phone'];
    $address = $_POST['address'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $status = $_POST['status'];
    $order_date = $_POST['order_date'];
    $return_date = $_POST['return_date'];

    // Update query
    $query = "UPDATE orders 
              SET customer_name=?, phone=?, alt_phone=?, address=?, product_id=?, product_name=?, 
                  status=?, order_date=?, return_date=? 
              WHERE id=?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssi", $customer_name, $phone, $alt_phone, $address, $product_id, 
                      $product_name, $status, $order_date, $return_date, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order updated successfully!'); window.location.href='view_complate.php';</script>";
    } else {
        echo "<script>alert('Error updating order');</script>";
    }
}
?>
