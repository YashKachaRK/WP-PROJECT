<?php
session_start();
include_once ("templates/nav.php");
include_once("asset/db_connection.php"); // Include database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT full_name, email,phone FROM users_register WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $full_name = htmlspecialchars($user['full_name']);
    $email = htmlspecialchars($user['email']);
    $phone = htmlspecialchars($user['phone']);
} else {
    die("User not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <div class="flex-1 p-8">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Profile</h1>
        <button id="edit-profile-btn" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Edit Profile</button>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-lg col-span-1 lg:col-span-2">
          <div class="flex justify-center mb-4">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-500">
              <img src="https://www.w3schools.com/w3images/avatar2.png" alt="User Avatar" class="w-full h-full object-cover">
            </div>
          </div>
          <h2 class="text-xl font-semibold text-center mb-2" id="profile-name"><?php echo $full_name; ?></h2>
          <p class="text-center text-gray-500 mb-4" id="profile-email"><?php echo $email; ?></p>
          <div class="space-y-4">
            <div class="flex justify-between text-gray-700">
              <span>Email:</span>
              <span class="font-medium" id="profile-email-display"><?php echo $email; ?></span>
            </div>

            <div class="flex justify-between text-gray-700">
              <span>Phone:</span>
              <span class="font-medium" id="profile-email-display"><?php echo $phone; ?></span>
            </div>
           
           
           
          </div>
        </div>

         <!-- Edit Profile Modal -->
  <div id="edit-profile-modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden justify-center items-center">
    <div class="bg-white rounded-lg p-8 w-96 shadow-2xl">
      <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>
      <form id="edit-profile-form">
        <input type="hidden" id="user-id" value="<?php echo $user_id; ?>">

        <div class="mb-4">
          <label for="edit-name" class="block text-sm text-gray-700">Full Name</label>
          <input type="text" id="edit-name" class="w-full px-4 py-2 border rounded-md focus:border-blue-500" value="<?php echo $user['full_name']; ?>" />
        </div>

        <div class="mb-4">
          <label for="edit-email" class="block text-sm text-gray-700">Email</label>
          <input type="email" id="edit-email" class="w-full px-4 py-2 border rounded-md focus:border-blue-500" value="<?php echo $user['email']; ?>" />
        </div>

        <div class="mb-4">
          <label for="edit-email" class="block text-sm text-gray-700">Phone</label>
          <input type="phone" id="edit-phone" class="w-full px-4 py-2 border rounded-md focus:border-blue-500" value="<?php echo $user['phone']; ?>" />
        </div>

        <div class="flex justify-end">
          <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Save Changes</button>
        </div>
      </form>
      <button id="close-modal-btn" class="absolute top-2 left-2 text-gray-600 text-2xl">&times;</button>
    </div>
  </div>

  <script>
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const modal = document.getElementById('edit-profile-modal');
    const form = document.getElementById('edit-profile-form');

    // Open modal
    editProfileBtn.addEventListener('click', () => {
      modal.classList.remove('hidden');
    });

    // Close modal
    closeModalBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const userId = document.getElementById('user-id').value;
      const name = document.getElementById('edit-name').value;
      const email = document.getElementById('edit-email').value;
      const phone = document.getElementById('edit-phone').value;

      // AJAX request to update user info
      fetch('update_profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${userId}&name=${name}&email=${email}&phone=${phone}`
      })
      .then(response => response.text())
      .then(data => {
        if (data === "success") {
          document.getElementById('profile-name').textContent = name;
          document.getElementById('profile-email').textContent = email;
          modal.classList.add('hidden');
        } else {
          alert("Failed to update profile");
        }
      });
    });
  </script>

      </div>
    </div>
  </div>
</body>
</html>
