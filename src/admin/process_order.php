<?php
include 'asset/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $alt_phone = $_POST['alt_phone'];
    $address = $_POST['address'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $total_amount = $_POST['total_amount'];
    $deposit_amount = $_POST['deposit_amount'];
    $remaining_amount = $total_amount - $deposit_amount;
    $status = $_POST['status'];
    $order_date = $_POST['order_date'];
    $return_date = $_POST['return_date'];

    // Insert data into database
    $sql = "INSERT INTO orders (customer_name, email, phone, alt_phone, address, product_id, product_name, total_amount, deposit_amount, remaining_amount, status, order_date, return_date)
            VALUES ('$customer_name', '$email', '$phone', '$alt_phone', '$address', '$product_id', '$product_name', '$total_amount', '$deposit_amount', '$remaining_amount', '$status', '$order_date', '$return_date')";

    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn); // Get last inserted order ID
        echo json_encode(["success" => true, "order_id" => $order_id]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
