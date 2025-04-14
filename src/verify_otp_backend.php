<?php
session_start();

// Check if OTP is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = $_POST['otp'];

    // Check if OTP and email are stored in session
    if (isset($_SESSION['otp']) && isset($_SESSION['email'])) {
        $storedOtp = $_SESSION['otp'];
        $userEmail = $_SESSION['email'];

        // Optionally: check OTP expiration time if you stored it earlier

        if ($enteredOtp == $storedOtp) {
            // OTP verified, redirect to reset password page
            header("Location: reset_password.php");
            exit();
        } else {
            // OTP incorrect
            echo "<script>alert('Invalid OTP. Please try again.'); window.location.href='otp_verify.php';</script>";
        }
    } else {
        echo "<script>alert('Session expired or OTP not found. Please try again.'); window.location.href='forgot_password.php';</script>";
    }
} else {
    // Prevent direct access
    header("Location: forgot_password.php");
    exit();
}
?>
