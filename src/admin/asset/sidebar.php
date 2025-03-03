<script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">

   <!-- Mobile Sidebar Toggle -->
    <button id="menu-toggle" class="md:hidden p-3 fixed top-4 left-4 bg-gray-800 text-white rounded-lg z-50">
        ☰
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white shadow-lg h-screen p-5 fixed top-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div class="text-2xl font-bold text-center py-4">Logo</div>
        <nav>
            <ul class="space-y-4">
                <li><a href="dashboard.php" class="block p-3 rounded-lg hover:bg-gray-200">🏠 Dashboard</a></li>
                <!-- Products Dropdown -->
                <li>
                    <button id="products-toggle" class="block w-full text-left p-3 rounded-lg hover:bg-gray-200 flex justify-between items-center">
                        🛍️ Products
                        <span id="products-icon">▼</span>
                    </button>
                    <ul id="products-menu" class="max-h-0 overflow-hidden opacity-0 transform scale-y-95 transition-all duration-200 ease-in-out origin-top space-y-2 pl-6">
                        <li><a href="add_product.php" class="block p-2 rounded-lg hover:bg-gray-200">➕ Add Product</a></li>
                        <li><a href="show_all_product.php" class="block p-2 rounded-lg hover:bg-gray-200">📋 Show All Products</a></li>
                    </ul>
                </li>

                <script>
                    const productsToggle = document.getElementById("products-toggle");
                    const productsMenu = document.getElementById("products-menu");
                    const productsIcon = document.getElementById("products-icon");

                    productsToggle.addEventListener("click", () => {
                        if (productsMenu.classList.contains("opacity-0")) {
                            // Open the dropdown immediately
                            productsMenu.classList.remove("max-h-0", "opacity-0", "scale-y-95");
                            productsMenu.classList.add("opacity-100", "scale-y-100");
                            productsIcon.textContent = "▲";
                        } else {
                            // Close the dropdown instantly
                            productsMenu.classList.add("opacity-0", "scale-y-95", "max-h-0");
                            productsMenu.classList.remove("opacity-100", "scale-y-100");
                            productsIcon.textContent = "▼";
                        }
                    });
                </script>

                
               <!-- Orders Dropdown -->
                <li>
                    <button id="orders-toggle" class="block w-full text-left p-3 rounded-lg hover:bg-gray-200 flex justify-between items-center">
                        📦 Orders
                        <span id="orders-icon">▼</span>
                    </button>
                    <ul id="orders-menu" class="max-h-0 overflow-hidden opacity-0 transform scale-y-95 transition-all duration-200 ease-in-out origin-top space-y-2 pl-6">
                        <li><a href="view_order.php" class="block p-2 rounded-lg hover:bg-gray-200">🔍 View Orders</a></li>
                        <li><a href="add_order.php" class="block p-2 rounded-lg hover:bg-gray-200">➕ Add Order</a></li>
                        <li><a href="view_rented_order.php" class="block p-2 rounded-lg hover:bg-gray-200">👗 Rented Order</a></li>
                        <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-200">📝 Order History</a></li>
                        <li><a href="view_today.php" class="block p-2 rounded-lg hover:bg-gray-200">🔄 Today Return</a></li>
                        <li>
                        <a href="view_complate.php" class="block p-2 rounded-lg hover:bg-gray-200">✅ Completed Orders</a>
                        </li>

                    </ul>
                </li>

                <script>
                    const ordersToggle = document.getElementById("orders-toggle");
                    const ordersMenu = document.getElementById("orders-menu");
                    const ordersIcon = document.getElementById("orders-icon");

                    ordersToggle.addEventListener("click", () => {
                        if (ordersMenu.classList.contains("opacity-0")) {
                            // Open dropdown smoothly
                            ordersMenu.classList.remove("max-h-0", "opacity-0", "scale-y-95");
                            ordersMenu.classList.add("opacity-100", "scale-y-100");
                            ordersIcon.textContent = "▲";
                        } else {
                            // Close dropdown instantly
                            ordersMenu.classList.add("opacity-0", "scale-y-95", "max-h-0");
                            ordersMenu.classList.remove("opacity-100", "scale-y-100");
                            ordersIcon.textContent = "▼";
                        }
                    });
                </script>


                <li><a href="customer.php" class="block p-3 rounded-lg hover:bg-gray-200">👥 Customers</a></li>
                <li><a href="#" class="block p-3 rounded-lg hover:bg-gray-200">📊 Reports</a></li>
                <li><a href="#" class="block p-3 rounded-lg hover:bg-gray-200">⚙️ Settings</a></li>
            </ul>
        </nav>
    </aside>
    <script>
        const menuToggle = document.getElementById("menu-toggle");
        const sidebar = document.getElementById("sidebar");
        const ordersToggle = document.getElementById("orders-toggle");
        const ordersMenu = document.getElementById("orders-menu");
        const ordersIcon = document.getElementById("orders-icon");

        // Toggle Sidebar for Mobile
        menuToggle.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
        });

        // Toggle Orders Sub-menu
        ordersToggle.addEventListener("click", () => {
            ordersMenu.classList.toggle("hidden");
            ordersIcon.textContent = ordersMenu.classList.contains("hidden") ? "▼" : "▲";
        });

        
    </script>
<!-- JavaScript for Toggle Functionality -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuToggle = document.getElementById("menu-toggle");
        const sidebar = document.getElementById("sidebar");

        menuToggle.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
        });
    });
</script>