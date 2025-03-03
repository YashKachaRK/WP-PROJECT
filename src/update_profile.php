<?php
include_once("asset/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "UPDATE users_register SET full_name=?, email=?, phone=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $phone, $user_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
    $conn->close();
}
?>
