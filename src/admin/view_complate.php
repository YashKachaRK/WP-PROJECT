<?php
include_once("asset/db_connection.php"); // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complated Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <?php include_once("asset/sidebar.php") ?>

    <main class="md:ml-64 p-8 transition-all duration-300">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Complated Order</h2>
        <nav class="text-sm text-gray-600">
            <ol class="flex space-x-2">
                <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><a href="view_complate.php" class="hover:text-gray-900 font-semibold">Complated Order</a></li>
            </ol>
        </nav>  

        <!-- Search Input -->
        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Search by Order ID, Product ID, or Customer Name"
                class="w-full md:w-1/3 p-3 border rounded-lg shadow-sm focus:ring focus:ring-blue-300 outline-none">
        </div>

        <!-- Orders Table (Data will be updated dynamically) -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-6" id="orderTable">
            <!-- Orders will be loaded here dynamically -->
        </div>
    </main>

    <script>
        $(document).ready(function() {
            function fetchOrders(query = '') {
                $.ajax({
                    url: "complate_order.php",
                    method: "POST",
                    data: { search: query },
                    success: function(response) {
                        $("#orderTable").html(response);
                    }
                });
            }

            fetchOrders(); // Load all orders initially

            $("#searchInput").on("keyup", function() {
                let query = $(this).val();
                fetchOrders(query);
            });
        });

        $(document).ready(function () {
        $(document).on("change", ".status-dropdown", function () {
            let orderId = $(this).data("order-id");
            let newStatus = $(this).val();
            
            $.ajax({
                url: "update_status.php",
                method: "POST",
                data: { order_id: orderId, status: newStatus },
                success: function (response) {
                    if (response.trim() === "success") {
                        alert("Status updated successfully!");
                    } else {
                        alert("Error updating status.");
                    }
                }
            });
        });
    });

    </script>
</body>
</html>
