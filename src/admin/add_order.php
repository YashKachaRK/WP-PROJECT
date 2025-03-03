<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/@preline/preline@latest/dist/preline.css">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Sidebar -->
    <?php include_once("asset/sidebar.php"); ?>

    <!-- Main Content -->
    <main class="md:ml-64 p-8 transition-all duration-300">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">🛍️ Add New Order</h2>
        <nav class="text-sm text-gray-600">
            <ol class="flex space-x-2">
                <li><a href="dashboard.php" class="hover:text-gray-900">Home</a></li>
                <li>/</li>
                <li><a href="add_order.php" class="hover:text-gray-900 font-semibold">Add New Orders</a></li>
            </ol>
        </nav>

        <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
            <form id="orderForm" action="process_order.php" method="POST" class="space-y-4">

                <!-- Customer Name -->
                <div>
                    <label class="block font-medium text-gray-700">👤 Customer Name</label>
                    <input type="text" name="customer_name" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter customer name">
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-medium text-gray-700">📧 Email</label>
                    <input type="email" name="email" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter email">
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block font-medium text-gray-700">📞 Phone Number</label>
                    <input type="tel" name="phone" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter phone number">
                </div>

                <!-- Alternative Phone Number -->
                <div>
                    <label class="block font-medium text-gray-700">📞 Alternative Number</label>
                    <input type="tel" name="alt_phone"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter alternative phone number">
                </div>

                <!-- Address -->
                <div>
                    <label class="block font-medium text-gray-700">📍 Address</label>
                    <textarea name="address" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter address"></textarea>
                </div>

                <!-- Product ID -->
                <div>
                    <label class="block font-medium text-gray-700">🔖 Product ID</label>
                    <input type="text" name="product_id" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter product ID">
                </div>

                <!-- Product Name -->
                <div>
                    <label class="block font-medium text-gray-700">📦 Product Name</label>
                    <input type="text" name="product_name" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter product name">
                </div>

                <!-- Product Amount -->
                <div>
                    <label class="block font-medium text-gray-700">💰 Product Amount</label>
                    <input type="number" id="total_amount" name="total_amount" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter total amount">
                </div>

                <!-- Deposit Amount -->
                <div>
                    <label class="block font-medium text-gray-700">💵 Deposit Amount</label>
                    <input type="number" id="deposit_amount" name="deposit_amount" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Enter deposit amount">
                </div>

                <!-- Remaining Amount (Auto-Calculated) -->
                <div>
                    <label class="block font-medium text-gray-700">🧮 Remaining Amount</label>
                    <input type="text" id="remaining_amount" readonly
                        class="w-full mt-1 px-4 py-2 border bg-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm"
                        placeholder="Remaining amount">
                </div>

                <!-- Order Status -->
                <div>
                    <label class="block font-medium text-gray-700">📦 Order Status</label>
                    <select name="status" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm">
                        <option value="Pending">⏳ Pending</option>
                        <option value="Completed">✅ Completed</option>
                        <option value="Cancelled">❌ Cancelled</option>
                        <option value="Rented">📦 Rented</option>
                        <option value="Return">🔄 Return</option>
                        <option value="Laundry">🧺 Laundry</option>
                    </select>
                </div>

                <!-- Order Date -->
                <div>
                    <label class="block font-medium text-gray-700">📅 Order Date</label>
                    <input type="date" name="order_date" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm">
                </div>

                <!-- Return Date -->
                <div>
                    <label class="block font-medium text-gray-700">🔄 Return Date</label>
                    <input type="date" name="return_date" required
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 shadow-sm">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-700 transition">
                        ➕ Add Order
                    </button>
                </div>

            </form>

            <!-- Download Bill Button (Initially Hidden) -->
            <div id="downloadBill" class="mt-4 hidden text-center">
                <a id="billLink" href="#" target="_blank"
                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:bg-green-700 transition">
                    📄 Download Bill
                </a>
            </div>

            

        </div>
    </main>

    <script>
        document.getElementById('total_amount').addEventListener('input', calculateRemaining);
        document.getElementById('deposit_amount').addEventListener('input', calculateRemaining);

        function calculateRemaining() {
            let total = parseFloat(document.getElementById('total_amount').value) || 0;
            let deposit = parseFloat(document.getElementById('deposit_amount').value) || 0;
            let remaining = total - deposit;
            document.getElementById('remaining_amount').value = remaining.toFixed(2);
        }

        // Show "Download Bill" button after submitting the form
        document.getElementById('orderForm').addEventListener('submit', function (event) {
            event.preventDefault();
            // Simulate form submission (you should use AJAX or proper PHP processing)
            setTimeout(() => {
                document.getElementById('downloadBill').classList.remove('hidden');
            }, 500);
        });
    </script>
<script>
    document.getElementById('orderForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);

        fetch('process_order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let billLink = document.getElementById('billLink');
                billLink.href = `generate_bill.php?order_id=${data.order_id}`;
                document.getElementById('downloadBill').classList.remove('hidden');
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>


<!-- <script>
    document.getElementById('orderForm').addEventListener('submit', function() {
        setTimeout(() => {
            this.reset(); // Clears the form after submission
        }, 2000); // Adjust delay if needed
    });
</script> -->

</body>
</html>
