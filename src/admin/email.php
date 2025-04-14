<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'gprjtsem5@gmail.com'; // Replace with your email
    $mail->Password = 'yash*786'; // Replace with your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // Use 465 for SSL, 587 for TLS

    // Email Details
    $mail->setFrom('gprjtsem5@gmail.com', 'Yash');
    $mail->addAddress('kachayash13@gmail.com', 'Yash');
    $mail->Subject = 'Test Email';
    $mail->Body    = 'Hello, this is a test email sent from PHP using PHPMailer!';

    // Send Email
    $mail->send();
    echo '✅ Email sent successfully!';
} catch (Exception $e) {
    echo "❌ Error: {$mail->ErrorInfo}";
}
?>
