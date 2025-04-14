<?php
session_start();
require 'asset/db_connection.php'; // Make sure this contains your DB connection

// Redirect if no email in session
if (!isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $email = $_SESSION['email'];

    if ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (strlen($newPassword) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in DB
        $stmt = $conn->prepare("UPDATE users_register SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        if ($stmt->execute()) {
            session_destroy();
            header("Location: login.php?reset=success");
            exit();
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
  <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-tr from-purple-100 via-blue-100 to-pink-100 flex items-center justify-center min-h-screen px-4">

  <div class="bg-white shadow-2xl rounded-3xl p-10 max-w-md w-full">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Reset Your Password</h2>
    <p class="text-gray-500 text-center mb-6 text-sm">Enter a strong new password for your account.</p>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6">
      <div>
        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
        <input type="password" id="new_password" name="new_password" required minlength="6" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all" />
      </div>

      <div>
        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all" />
      </div>

      <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold py-3 rounded-xl shadow-lg hover:from-blue-600 hover:to-purple-600 transition duration-300">
        Reset Password
      </button>
    </form>
  </div>

</body>
</html>
