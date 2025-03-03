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

// Fetch Total Products
$product_query = "SELECT COUNT(*) AS total_products FROM products";
$product_result = $conn->query($product_query);
$product_row = $product_result->fetch_assoc();
$total_products = $product_row['total_products'];

$query = "SELECT COUNT(*) AS total_orders FROM orders";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_orders = $row['total_orders'];

// Fetch total customer count
$query = "SELECT COUNT(*) AS total_customers FROM users_register";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$total_customers = $row['total_customers'];


$today = date("Y-m-d"); // Get today's date

// Query to count the number of rented products that should be returned today
$sql = "SELECT COUNT(*) as total_returned FROM orders WHERE status = 'Rented' AND return_date = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_returned = $row['total_returned'] ?? 0; 

// Query to count the number of rented products that should be returned today
// ✅ Fix query execution
$sql = "SELECT COUNT(*) as total_returned FROM orders WHERE status = 'Completed'";
$result = $conn->query($sql); // ✅ Correct variable name

// ✅ Fetch data safely
$row = $result->fetch_assoc();
$total_complete = $row['total_returned'] ?? 0;

// ✅ Fetch total income from completed orders
$sql = "SELECT SUM(total_amount) as total_income FROM orders WHERE status = 'Completed'";
$result = $conn->query($sql);

// ✅ Fetch the result safely
$row = $result->fetch_assoc();
$total_income = $row['total_income'] ?? 0; // ✅ Handle null values

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">
</head>
<body class="bg-gray-50 text-gray-900">
    <?php include_once("asset/sidebar.php") ?>

    <!-- Main Content -->
    <main class="md:ml-64 p-8 transition-all duration-300">
        <nav class="text-sm text-gray-600">
            <ol class="flex space-x-2">
                <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><a href="dashboard.php" class="hover:text-gray-900 font-semibold">Dashboard</a></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold mt-4">Dashboard</h1>
        <p class="text-gray-700 mt-2">Welcome to your admin panel.</p>

        <!-- Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <div class="bg-white shadow-lg p-5 rounded-lg">
                <h2 class="text-xl font-semibold">📦 Total Orders</h2>
                <p class="text-2xl font-bold"><?= number_format($total_orders); ?></p>
            </div>
            <div class="bg-white shadow-lg p-5 rounded-lg">
                <h2 class="text-xl font-semibold">🛍️ Products</h2>
                <p class="text-2xl font-bold"><?php echo $total_products; ?></p>
            </div>
            <div class="bg-white shadow-lg p-5 rounded-lg">
                <h2 class="text-xl font-semibold">👥 Customers</h2>
                <p class="text-2xl font-bold"><?= number_format($total_customers); ?></p>
            </div>

            <div class="bg-white shadow-lg p-5 rounded-lg">
                <h2 class="text-xl font-semibold">🔄 Today Return</h2>
                <p class="text-2xl font-bold"><?= number_format($total_returned); ?></p>
            </div>

            <div class="bg-white shadow-lg p-5 rounded-lg">
                <h2 class="text-xl font-semibold">✅ Completed Orders</h2>
                <p class='text-2xl font-bold'><?= number_format((float)$total_complete); ?></p>
            </div>

            <div class="bg-white shadow-lg p-5 rounded-lg">
                <h2 class="text-xl font-semibold">💰 Total Income</h2>
                <p class="text-2xl font-bold text-green-600">₹<?= number_format((float)$total_income, 2); ?></p>
            </div>

        </div>
    </main>
</body>
</html>
