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

// Fetch Products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">
</head>
<body class="bg-gray-100 text-gray-900">

<?php include_once("asset/sidebar.php"); ?>

<!-- Main Content -->
<main class="md:ml-64 p-8 transition-all duration-300">
    <nav class="text-sm text-gray-600">
        <ol class="flex space-x-2">
            <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
            <li>/</li>
            <li><a href="#" class="hover:text-gray-900 font-semibold">Show All Products</a></li>
        </ol>
    </nav>

    <div class="bg-white shadow-xl rounded-lg p-6 mt-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">All Products</h1>
        <p class="text-gray-600">Manage and view all available products.</p>

        <!-- Search Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6 space-y-4 md:space-y-0">
            <input type="text" id="searchInput" placeholder="🔍 Search by ID or Name..."
                class="w-full md:w-1/3 border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Products Table -->
        <div class="overflow-x-auto mt-6">
            <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden border">
                <thead class="bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Product Name</th>
                        <th class="p-4 text-left">Category</th>
                        <th class="p-4 text-left">Gender</th>
                        <th class="p-4 text-left">Rental Price</th>
                        <th class="p-4 text-left">Availability</th>
                        <th class="p-4 text-left">Image</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTable" class="text-gray-700">
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-b hover:bg-gray-100 transition">
                        <td class="p-4"><?php echo $row['id']; ?></td>
                        <td class="p-4"><?php echo $row['product_name']; ?></td>
                        <td class="p-4"><?php echo $row['category']; ?></td>
                        <td class="p-4"><?php echo $row['gender']; ?></td>
                        <td class="p-4 text-green-600 font-semibold">$<?php echo $row['rental_price']; ?></td>
                        <td class="p-4">
                            <span class="px-3 py-1 text-sm font-semibold <?php echo ($row['availability'] == 'Available') ? 'bg-green-500' : 'bg-red-500'; ?> text-white rounded-full">
                                <?php echo $row['availability']; ?>
                            </span>
                        </td>
                        <td class="p-4">
                            <img src="<?php echo $row['image']; ?>" alt="Product Image" class="w-16 h-16 rounded-lg shadow">
                        </td>
                        <td class="p-4 flex space-x-3">
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 transition">
                                ✏️ Edit
                            </a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="px-4 py-2 bg-red-500 text-white rounded-md shadow-md hover:bg-red-600 transition">
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

<!-- JavaScript for Search Functionality -->
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#productTable tr");

        rows.forEach(row => {
            let id = row.cells[0].textContent.toLowerCase();
            let name = row.cells[1].textContent.toLowerCase();
            row.style.display = (id.includes(filter) || name.includes(filter)) ? "" : "none";
        });
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
