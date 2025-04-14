<?php
include("asset/db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['id'];
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT password FROM users_register WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current, $hashedPassword)) {
        $newHashed = password_hash($new, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users_register SET password = ? WHERE id = ?");
        $update->bind_param("si", $newHashed, $user_id);
        if ($update->execute()) {
            echo "success";
        } else {
            echo "Failed to update password.";
        }
        $update->close();
    } else {
        echo "Current password is incorrect.";
    }

    $conn->close();
}
?>
