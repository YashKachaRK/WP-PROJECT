<!-- qcws jlko jgjn rvid -->
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// Autoload PHPMailer (if using Composer)
require 'vendor/autoload.php';

// DB connection
$host = 'localhost';
$db = 'final';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);

  // Check if email exists
  $stmt = $conn->prepare("SELECT id FROM users_register WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    // ✅ Email exists

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store OTP and email in session (or save in DB)
    $_SESSION['email'] = $email;
    $_SESSION['otp'] = $otp;

    // Send email via PHPMailer
    $mail = new PHPMailer(true);

    try {
      // SMTP Config
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'yashkacha213@gmail.com'; // use app password if 2FA enabled
      $mail->Password   = 'qcws jlko jgjn rvid';
      $mail->SMTPSecure = 'tls';
      $mail->Port       = 587;

      // Email Info
      $mail->setFrom('yashkacha213@gmail.com', 'Wedding Rental App');
      $mail->addAddress($email);

      $mail->isHTML(true);
      $mail->Subject = 'Your OTP for Password Reset';
      $mail->Body    = "<p>Your OTP is: <strong>$otp</strong></p><p>It is valid for 10 minutes.</p>";

      $mail->send();

      echo "<script>
        alert('OTP has been sent to your email.');
        window.location.href = 'otp_verify.php';
      </script>";

    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

  } else {
    // ❌ Email not found
    echo "<script>
      alert('Email not found. Please try again.');
      window.history.back();
    </script>";
  }

  $stmt->close();
}

$conn->close();
?>
