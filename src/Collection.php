<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Now include other files or HTML content
?>
<?php
include_once("templates/nav.php");
?>
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from database
$query = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Our Collection</h2>
        <!-- Search Product -->

       

        <!-- Search Bar and Filter Button -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-6"> <!-- Increased spacing -->
                <input type="text" id="search" placeholder="Search products..."
                    class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 w-80 shadow-sm">
                <button class="px-5 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    🔍 Search
                </button>

                <!-- Vertical Divider -->
                <div class="border-l border-gray-300 h-10"></div>

                <button onclick="openModal()"
                    class="px-5 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition">
                    ⚙️ Filter
                </button>
            </div>
        </div>

        <!-- Modal Background -->
        <div id="filterModal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity">
            <div class="bg-white p-6 rounded-lg shadow-2xl w-96 transform scale-95 transition-all duration-300"
                id="modalContent">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">🔎 Filters</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-lg">✖</button>
                </div>

                <!-- Category Filter -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">📁 Category</label>
                    <select class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 shadow-sm">
                        <option value="all">All Categories</option>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">🎭 Type</label>
                    <select class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 shadow-sm">
                        <option value="all">All Types</option>
                        <option value="sherwani">Sherwani</option>
                        <option value="lehenga">Lehenga</option>
                        <option value="suit">Suit</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="mb-4">
                    <label class="text-gray-700 font-medium mb-1">💰 Price Range</label>
                    <div class="flex items-center gap-3">
                        <span class="text-gray-600">₹1000</span>
                        <input type="range" min="1000" max="20000" step="500" class="w-full accent-indigo-600"
                            id="priceRange" oninput="updatePrice()">
                        <span class="text-gray-800 font-semibold" id="priceValue">₹20,000</span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center mt-4">
                    <button onclick="resetFilters()"
                        class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition">
                        🗑 Clear
                    </button>
                    <div class="flex gap-3">
                        <button onclick="closeModal()"
                            class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition">
                            ❌ Cancel
                        </button>
                        <button onclick="closeModal()"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            ✅ Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Product Grid -->
        <section id="Projects"
            class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">


        <!-- Success Message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-3 mt-3 rounded">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <!-- ✅ Product Card with Clickable Details Page -->
        <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
        <a href="product_details.php?id=<?= $row['id']; ?>">
        <img src="<?= 'admin/uploads/' . basename($row['image']); ?>" alt="Product Image" class="h-80 w-72 object-cover rounded-t-xl" />

            <div class="px-4 py-3 w-72">
            <span class="text-gray-400 mr-3 uppercase text-xs"><?= $row['category']; ?></span>
            <p class="text-lg font-bold text-black truncate capitalize"><?= $row['product_name']; ?></p>
                <div class="flex items-center">
                <p class="text-lg font-semibold text-black my-3">₹<?= $row['rental_price']; ?></p>
                  
                    <div class="ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-bag-plus" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                            <path
                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Rent Now / Login Now Button -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="product_details.php?id=<?= $row['id']; ?>"            class="block text-center bg-indigo-600 text-white font-medium py-2 mt-3 rounded-lg 
            hover:bg-indigo-700 transition duration-300">
                Rent Now
            </a>
        <?php else: ?>
            <a href="login.php" class="block text-center bg-red-600 text-white font-medium py-2 mt-3 rounded-lg 
            hover:bg-red-700 transition duration-300">
                Login Now
            </a>
        <?php endif; ?>
</div>
<?php endwhile; ?>



        </section>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById("filterModal");
            const modalContent = document.getElementById("modalContent");
            modal.classList.remove("hidden");
            setTimeout(() => modalContent.classList.add("scale-100"), 10); // Animation effect
        }

        function closeModal() {
            const modal = document.getElementById("filterModal");
            const modalContent = document.getElementById("modalContent");
            modalContent.classList.remove("scale-100");
            setTimeout(() => modal.classList.add("hidden"), 200); // Delay for smooth closing
        }

        // Close modal when clicking outside
        document.getElementById("filterModal").addEventListener("click", function (e) {
            if (e.target === this) closeModal();
        });

        function updatePrice() {
            document.getElementById("priceValue").innerText = "₹" + document.getElementById("priceRange").value;
        }

        function resetFilters() {
            document.querySelector("select").selectedIndex = 0;
            document.getElementById("priceRange").value = 20000;
            updatePrice();
        }
    </script>



    <script>
        function updatePrice() {
            document.getElementById('priceValue').innerText = '₹' + document.getElementById('priceRange').value;
        }
    </script>
</body>

</html>