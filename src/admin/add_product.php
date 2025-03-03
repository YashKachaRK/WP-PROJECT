<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Clothing Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include_once("asset/sidebar.php") ?>

    <!-- Main Content -->
    <main class="md:ml-64 p-8 transition-all duration-300">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600">
            <ol class="flex space-x-2">
                <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><a href="add_product.php" class="hover:text-gray-900 font-semibold">Add Product</a></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold mt-4">Add Product</h1>
        <p class="text-gray-700 mt-2">Enter product details for your clothing rental business.</p>

        <!-- Add Product Form -->
        <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
            <form action="save_product.php" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Name -->
                    <div>
                        <label class="block text-gray-700 font-semibold">Product Name</label>
                        <input type="text" name="product_name" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-gray-700 font-semibold">Category</label>
                        <select name="category" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Traditional">Traditional</option>
                            <option value="Casual">Casual</option>
                            <option value="Formal">Formal</option>
                            <option value="Bridal">Bridal</option>
                        </select>
                    </div>

                    <!-- Gender Type -->
                    <div>
                        <label class="block text-gray-700 font-semibold">Type</label>
                        <select name="gender" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Unisex">Unisex</option>
                        </select>
                    </div>

                    <!-- Rental Price -->
                    <div>
                        <label class="block text-gray-700 font-semibold">Rental Price (₹)</label>
                        <input type="number" name="rental_price" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <!-- Availability -->
                    <div>
                        <label class="block text-gray-700 font-semibold">Availability</label>
                        <select name="availability" required class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="Available">Available</option>
                            <option value="Rented">Rented</option>
                            <option value="Rented">RFC</option>
                        </select>
                    </div>

                    <!-- Product Image -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold">Product Image</label>
                        <input type="file" name="product_image" accept="image/*" required class="w-full mt-2 p-3 border rounded-lg">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition">
                        Add Product
                    </button>
                </div>
            </form>
        </div>

    </main>

  

</body>
</html>
