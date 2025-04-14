<?php
// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch All Users
$user_query = "SELECT id, full_name, email, phone FROM users_register";
$user_result = $conn->query($user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include_once("asset/sidebar.php") ?>

    <!-- Main Content -->
    <main class="md:ml-64 p-8 transition-all duration-300">
        <nav class="text-sm text-gray-600">
            <ol class="flex space-x-2">
                <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><span class="hover:text-gray-900 font-semibold">Customer</span></li>
            </ol>
        </nav>

        <div class="flex justify-between items-center mt-4">
            <h1 class="text-3xl font-bold text-gray-800">All Customer</h1>
        </div>
        <p class="text-gray-700 mt-2">Manage and view all registered users.</p>

        <!-- Users Table -->
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden border">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Full Name</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">Phone</th>
                            <th class="p-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700" id="userTable">
                        <?php while ($row = $user_result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="p-4"><?php echo $row['id']; ?></td>
                            <td class="p-4"><?php echo $row['full_name']; ?></td>
                            <td class="p-4"><?php echo $row['email']; ?></td>
                            <td class="p-4"><?php echo $row['phone']; ?></td>
                            <td class="p-4 flex space-x-3">
                                <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this user?');"
                                   class="px-4 py-2 bg-red-500 text-white rounded-md shadow-md hover:bg-red-600 transition">
                                    ❌ Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

<?php
$conn->close();
?>
