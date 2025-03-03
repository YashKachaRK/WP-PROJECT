<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "final";
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from URL
if (!isset($_GET['id'])) {
    die("Product ID not specified.");
}

$product_id = $_GET['id'];

// Fetch product from database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://preline.co/assets/scripts/preline.js"></script>
</head>
<body class="bg-gradient-to-r from-gray-100 to-gray-300 min-h-screen">
    
    <!-- Navbar -->
    <?php
    include_once('templates/nav.php');
    ?>
<!-- Main Content -->
<div class="flex items-center justify-center min-h-screen">
    <div class="max-w-4xl w-full bg-white/30 backdrop-blur-lg p-6 rounded-xl shadow-lg flex flex-col md:flex-row">
        
        <!-- Image Section -->
        <div class="md:w-1/2 p-4">
            <img src="<?php echo strpos($product['image'], 'uploads/') !== false ? 'admin/' . $product['image'] : 'admin/uploads/' . $product['image']; ?>" 
                alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                class="w-full rounded-lg shadow-lg hover:scale-105 transition-transform duration-300">
        </div>

        <!-- Details Section -->
        <div class="md:w-1/2 p-4 space-y-4">
            <h1 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <p class="text-gray-600"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
            <p class="text-gray-600"><strong>Gender:</strong> <?php echo htmlspecialchars($product['gender']); ?></p>
            <p class="text-red-500 text-xl font-semibold">₹<?php echo number_format($product['rental_price']); ?></p>
            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($product['description'] ?? 'No description available.')); ?></p>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-3 mt-4">
            <a href="cart.php?name=<?php echo urlencode($product['product_name']); ?>
                &price=<?php echo urlencode($product['rental_price']); ?>
                &type=<?php echo urlencode($product['category']); ?>
                &image=<?php echo urlencode('admin/' . $product['image']); ?>"
            class="px-6 py-2 text-white font-semibold bg-yellow-500 rounded-lg shadow-lg hover:bg-yellow-600 transition">
            Add to Cart
            </a>

                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="booked.php?name=<?php echo urlencode($product['product_name']); ?>
                        &price=<?php echo urlencode($product['rental_price']); ?>
                        &type=<?php echo urlencode($product['category']); ?>
                        &image=<?php echo urlencode('admin/' . $product['image']); ?>"
                        class="px-6 py-2 text-white font-semibold bg-blue-500 rounded-lg shadow-lg hover:bg-blue-600 transition">
                        Rent Now
                        </a>

                <?php else: ?>
                    <a href="login.php" 
                       class="px-6 py-2 text-white font-semibold bg-blue-500 rounded-lg shadow-lg hover:bg-blue-600 transition">
                       Login to Rent
                    </a>
                <?php endif; ?>
                
                <a href="javascript:history.back()" 
                   class="px-6 py-2 text-white font-semibold bg-gray-700 rounded-lg shadow-lg hover:bg-gray-800 transition">
                   Back
                </a>
            </div>
        </div>
    </div>
</div>


</body>
</html>

