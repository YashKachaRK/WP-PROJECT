<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-tr from-blue-100 via-purple-100 to-pink-100 flex items-center justify-center min-h-screen px-4">

  <div class="bg-white shadow-2xl rounded-3xl p-10 max-w-md w-full">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-2">Forgot Password?</h2>
    <p class="text-gray-500 text-center mb-6 text-sm">No worries, we’ll send you an OTP to reset it.</p>

    <form action="send_otp.php" method="POST" class="space-y-6">
      <div class="relative">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          placeholder="you@example.com"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold py-3 rounded-xl shadow-lg hover:from-blue-600 hover:to-purple-600 transition duration-300"
      >
        Get OTP
      </button>

      <div class="text-sm text-center text-gray-600 mt-4">
        <a href="login.php" class="text-blue-600 hover:underline transition">← Back to Login</a>
      </div>
    </form>
  </div>

</body>
</html>
