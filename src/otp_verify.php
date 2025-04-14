<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify OTP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-tr from-blue-100 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center px-4">

  <div class="bg-white shadow-2xl rounded-3xl p-10 max-w-md w-full">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Enter OTP</h2>
    <p class="text-gray-500 text-center mb-6 text-sm">We’ve sent an OTP to your email. Please enter it below.</p>

    <form action="verify_otp_backend.php" method="POST" class="space-y-6">
      <div>
        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">OTP</label>
        <input
          type="text"
          id="otp"
          name="otp"
          required
          maxlength="6"
          placeholder="Enter 6-digit code"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-400 focus:border-purple-400 outline-none transition-all"
        />
      </div>

      <!-- Optionally pass user email from session or hidden field -->
      <?php
        session_start();
        if (isset($_SESSION['email'])) {
          echo '<input type="hidden" name="email" value="' . htmlspecialchars($_SESSION['email']) . '">';
        }
      ?>

      <button
        type="submit"
        class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white font-semibold py-3 rounded-xl shadow-lg hover:from-purple-600 hover:to-blue-600 transition duration-300"
      >
        Verify OTP
      </button>

      <div class="text-sm text-center text-gray-600 mt-4">
        <a href="forgot_password.php" class="text-blue-600 hover:underline transition">← Resend OTP</a>
      </div>
    </form>
  </div>

</body>
</html>
