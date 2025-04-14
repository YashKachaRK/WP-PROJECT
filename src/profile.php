<?php
session_start();
include_once ("templates/nav.php");
include_once("asset/db_connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT full_name, email, phone FROM users_register WHERE id = ?";
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-100 to-blue-100 min-h-screen font-sans">

<div class="container mx-auto px-4 py-10">
  <div class="bg-white shadow-2xl rounded-lg p-8 max-w-4xl mx-auto">
    <div class="flex flex-col lg:flex-row justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-4 lg:mb-0">User Profile</h1>
      <div class="space-x-4">
        <button id="edit-profile-btn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">Edit Profile</button>
        <button id="change-password-btn" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">Change Password</button>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row items-center gap-8">
      <div class="w-32 h-32 rounded-full border-4 border-blue-400 overflow-hidden">
        <img src="https://www.w3schools.com/w3images/avatar2.png" class="w-full h-full object-cover" alt="Profile">
      </div>
      <div class="flex-1 space-y-4">
        <div>
          <h2 class="text-2xl font-semibold text-gray-700" id="profile-name"><?php echo $full_name; ?></h2>
          <p class="text-gray-500" id="profile-email"><?php echo $email; ?></p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="bg-gray-100 p-4 rounded-md">
            <p class="text-sm text-gray-600">Email</p>
            <p class="text-gray-800 font-medium" id="profile-email-display"><?php echo $email; ?></p>
          </div>
          <div class="bg-gray-100 p-4 rounded-md">
            <p class="text-sm text-gray-600">Phone</p>
            <p class="text-gray-800 font-medium" id="profile-phone-display"><?php echo $phone; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modals -->
<div id="edit-profile-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center z-50">
  <div class="bg-white rounded-xl p-8 w-96 shadow-xl relative">
    <button id="close-modal-btn" class="absolute top-2 right-3 text-gray-600 text-2xl font-bold">&times;</button>
    <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
    <form id="edit-profile-form" class="space-y-4">
      <input type="hidden" id="user-id" value="<?php echo $user_id; ?>">

      <input type="text" id="edit-name" placeholder="Full Name" class="w-full border px-4 py-2 rounded-md" value="<?php echo $user['full_name']; ?>" />
      <input type="email" id="edit-email" placeholder="Email" class="w-full border px-4 py-2 rounded-md" value="<?php echo $user['email']; ?>" />
      <input type="text" id="edit-phone" placeholder="Phone" class="w-full border px-4 py-2 rounded-md" value="<?php echo $user['phone']; ?>" />

      <div class="flex justify-end">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
      </div>
    </form>
  </div>
</div>

<div id="change-password-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center z-50">
  <div class="bg-white rounded-xl p-8 w-96 shadow-xl relative">
    <button id="close-password-modal-btn" class="absolute top-2 right-3 text-gray-600 text-2xl font-bold">&times;</button>
    <h2 class="text-xl font-bold mb-4">Change Password</h2>
    <form id="change-password-form" class="space-y-4">
      <input type="hidden" id="user-id-pass" value="<?php echo $user_id; ?>">

      <input type="password" id="current-password" placeholder="Current Password" class="w-full border px-4 py-2 rounded-md" required>
      <input type="password" id="new-password" placeholder="New Password" class="w-full border px-4 py-2 rounded-md" required>
      <input type="password" id="confirm-password" placeholder="Confirm New Password" class="w-full border px-4 py-2 rounded-md" required>

      <div class="flex justify-end">
        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">Change</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script>
  const editProfileBtn = document.getElementById('edit-profile-btn');
  const closeModalBtn = document.getElementById('close-modal-btn');
  const modal = document.getElementById('edit-profile-modal');
  const form = document.getElementById('edit-profile-form');

  editProfileBtn.addEventListener('click', () => modal.classList.remove('hidden'));
  closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const userId = document.getElementById('user-id').value;
    const name = document.getElementById('edit-name').value;
    const email = document.getElementById('edit-email').value;
    const phone = document.getElementById('edit-phone').value;

    fetch('update_profile.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${userId}&name=${name}&email=${email}&phone=${phone}`
    })
    .then(res => res.text())
    .then(data => {
      if (data === "success") {
        document.getElementById('profile-name').textContent = name;
        document.getElementById('profile-email').textContent = email;
        document.getElementById('profile-email-display').textContent = email;
        document.getElementById('profile-phone-display').textContent = phone;
        modal.classList.add('hidden');
      } else {
        alert("Failed to update profile");
      }
    });
  });

  const changePasswordBtn = document.getElementById('change-password-btn');
  const closePasswordModalBtn = document.getElementById('close-password-modal-btn');
  const changePasswordModal = document.getElementById('change-password-modal');
  const changePasswordForm = document.getElementById('change-password-form');

  changePasswordBtn.addEventListener('click', () => changePasswordModal.classList.remove('hidden'));
  closePasswordModalBtn.addEventListener('click', () => changePasswordModal.classList.add('hidden'));

  changePasswordForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const userId = document.getElementById('user-id-pass').value;
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword !== confirmPassword) {
      alert("New passwords do not match!");
      return;
    }

    fetch('change_password.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${userId}&current_password=${currentPassword}&new_password=${newPassword}`
    })
    .then(res => res.text())
    .then(data => {
      if (data === "success") {
        alert("Password changed successfully!");
        changePasswordForm.reset();
        changePasswordModal.classList.add('hidden');
      } else {
        alert(data);
      }
    });
  });
</script>

</body>
</html>
