<?php
include_once("asset/db_connection.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid Order ID.";
    exit;
}

$order_id = $_GET['id'];

$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Order not found.";
    exit;
}

$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complate Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gray-100 text-gray-900 ">
    <?php include_once("asset/sidebar.php") ?>

<!-- Main Content -->
<main class="md:ml-64 p-8 transition-all duration-300">
    <nav class="text-sm text-gray-600">
        <ol class="flex space-x-2">
            <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
            <li>/</li>
            <li><a href="view_complate.php" class="hover:text-gray-900 font-semibold">View Complate</a></li>
        </ol>
    </nav>

    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Complated Order</h2>


    <!-- Centering the Order Details -->
    <div class="flex items-center justify-center ">
        <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-4xl border border-gray-200">
            <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Complate Details</h2>

            <div class="grid grid-cols-2 gap-6 text-gray-700 border p-6 rounded-lg shadow-md bg-gray-50">
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Order ID:</span> <span>#<?= $order['id']; ?></span></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Product ID:</span> <?= $order['product_id']; ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Customer:</span> <?= $order['customer_name']; ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Phone:</span> <?= $order['phone']; ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Alt Phone:</span> <?= $order['alt_phone']; ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Email:</span> <?= $order['email']; ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Product Name:</span> <?= $order['product_name']; ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Amount:</span> ₹<?= number_format($order['total_amount'], 2); ?></p>
                <p class="flex items-center"><span class="font-semibold w-40 text-gray-800">Status:</span> 
                    <span class="px-3 py-1 rounded-lg text-white 
                        <?= $order['status'] == 'Rented' ? 'bg-yellow-500' : ($order['status'] == 'Completed' ? 'bg-green-500' : ($order['status'] == 'Cancelled' ? 'bg-red-500' : 'bg-gray-500')) ?>">
                        <?= $order['status']; ?>
                    </span>
                </p>
                <p class="flex items-center">
                    <span class="font-semibold w-40 text-gray-800">Order Date:</span> 
                    <?= date('d-m-Y', strtotime($order['order_date'])); ?>
                </p>
                <p class="flex items-center">
                    <span class="font-semibold w-40 text-gray-800">Return Date:</span> 
                    <?= date('d-m-Y', strtotime($order['return_date'])); ?>
                </p>
            </div>

           

            <!-- Modal -->
            <div x-data="{ open: false }">
            <div class="mt-8 flex justify-between">
                <a href="view_complate.php" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">Back</a>
                <a href="#" @click="open = true" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">
                    Edit Order
                </a>
           
            </div>
                   <!-- Edit Order Button -->
            
<!-- Modal -->
<div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg p-6 rounded-2xl shadow-2xl transform transition-all">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Edit Order</h2>
            <button @click="open = false" class="text-gray-500 hover:text-red-600 text-3xl font-bold">&times;</button>
        </div>

        <!-- Modal Body (Form) -->
        <form action="update_complate.php" method="POST" class="mt-6 space-y-4">
            <!-- Hidden Input for Order ID -->
            <input type="hidden" name="order_id" value="<?= $order['id']; ?>">

            <!-- Customer Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Customer Name</label>
                <input type="text" name="customer_name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['customer_name']; ?>">
            </div>

            <!-- Phone Number -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone Number</label>
                    <input type="text" name="phone" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['phone']; ?>">
                </div>

                <!-- Alternative Phone Number -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Alternative Phone</label>
                    <input type="text" name="alt_phone" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['alt_phone']; ?>">
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Address</label>
                <textarea name="address" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400"><?= $order['address']; ?></textarea>
            </div>

            <!-- Product Details -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Product ID</label>
                    <input type="text" name="product_id" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['product_id']; ?>">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Product Name</label>
                    <input type="text" name="product_name" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['product_name']; ?>">
                </div>
            </div>

            <!-- Status Selection -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <select name="status" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400">
                    <?php
                    $statuses = ['Pending', 'Completed', 'Cancelled', 'Rented', 'Return', 'Laundry'];
                    foreach ($statuses as $status) {
                        $selected = ($order['status'] === $status) ? 'selected' : '';
                        echo "<option value='$status' $selected>$status</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Date Fields -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Order Date</label>
                    <input type="date" name="order_date" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['order_date']; ?>">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Return Date</label>
                    <input type="date" name="return_date" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400" value="<?= $order['return_date']; ?>">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" @click="open = false" class="px-5 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-700 transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-800 transition shadow-md">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

            </div>
        </div>
    </div>
</main>

   
</body>
</html>

<?php
$conn->close();
?>
