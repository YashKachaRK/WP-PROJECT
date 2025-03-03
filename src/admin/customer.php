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

// Fetch All Customers
$customer_query = "SELECT id, full_name, email, phone, created_at FROM users_register";
$customer_result = $conn->query($customer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Customers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include_once("asset/sidebar.php") ?>

    <!-- Main Content -->
    <main class="md:ml-64 p-8 transition-all duration-300">
        <nav class="text-sm text-gray-600">
            <ol class="flex space-x-2">
                <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><a href="customer.php" class="hover:text-gray-900 font-semibold">Customers</a></li>
            </ol>
        </nav>

        <div class="flex justify-between items-center mt-4">
            <h1 class="text-3xl font-bold text-gray-800">All Customers</h1>
            <button id="openModal" class="px-6 py-3 bg-indigo-500 text-white rounded-lg shadow-md hover:bg-indigo-600 transition">
                ➕ Add Customer
            </button>
        </div>
        <p class="text-gray-700 mt-2">Manage and view all registered customers.</p>

        <!-- Customers Table -->
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden border">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Full Name</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">Phone</th>
                            <th class="p-4 text-left">Registered At</th>
                            <th class="p-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700" id="customerTable">
                        <?php while ($row = $customer_result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="p-4"><?php echo $row['id']; ?></td>
                            <td class="p-4"><?php echo $row['full_name']; ?></td>
                            <td class="p-4"><?php echo $row['email']; ?></td>
                            <td class="p-4"><?php echo $row['phone']; ?></td>
                            <td class="p-4"><?php echo date("d M Y, H:i A", strtotime($row['created_at'])); ?></td>
                            <td class="p-4 flex space-x-3">
                                <a href="delete_customer.php?id=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this customer?');"
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

    <!-- Modal -->
    <div id="customerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-2xl font-bold mb-4">Add New Customer</h2>
            <form id="addCustomerForm">
                <input type="text" name="full_name" id="full_name" placeholder="Full Name" class="w-full p-2 border rounded mb-3">
                <input type="email" name="email" id="email" placeholder="Email" class="w-full p-2 border rounded mb-3">
                <input type="text" name="phone" id="phone" placeholder="Phone" class="w-full p-2 border rounded mb-3">
                <button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-lg">Add Customer</button>
            </form>
            <button id="closeModal" class="mt-3 w-full bg-gray-300 py-2 rounded-lg">Cancel</button>
        </div>
    </div>

    <script>
        // Open Modal
        $("#openModal").click(() => {
            $("#customerModal").removeClass("hidden");
        });

        // Close Modal
        $("#closeModal").click(() => {
            $("#customerModal").addClass("hidden");
        });

        // Handle Form Submission
        $("#addCustomerForm").submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "add_customer.php",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response);
                    location.reload(); // Refresh table after adding
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
