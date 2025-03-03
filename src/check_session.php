<?php
session_start();
echo isset($_SESSION['user_id']) ? "Logged In as User ID: " . $_SESSION['user_id'] : "Not Logged In";
?>
