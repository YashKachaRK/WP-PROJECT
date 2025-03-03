<?php
include_once("asset/db_connection.php");

$search = "";
$sql = "SELECT * FROM orders WHERE status = 'Completed' ORDER BY order_date DESC"; // Default Query

// If search input is provided, modify the query
if (!empty($_POST['search'])) {
    $search = trim($_POST['search']);
    $sql = "SELECT * FROM orders 
            WHERE status = 'Rented' 
            AND (id LIKE ? OR product_id LIKE ? OR customer_name LIKE ?) 
            ORDER BY order_date DESC";
}

// Prepare the statement
$stmt = $conn->prepare($sql);

if (!empty($_POST['search'])) {
    $param = "%$search%";
    $stmt->bind_param("sss", $param, $param, $param);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<table class="w-full border-collapse rounded-lg overflow-hidden shadow-md">
    <thead class="bg-blue-600 text-white">
        <tr>
            <th class="px-6 py-3 text-left">Order ID</th>
            <th class="px-6 py-3 text-left">Product ID</th>
            <th class="px-6 py-3 text-left">Customer</th>
            <th class="px-6 py-3 text-left">Phone</th>
            <th class="px-6 py-3 text-left">Alt Phone</th>
            <th class="px-6 py-3 text-left">Email</th>
            <th class="px-6 py-3 text-left">Product Name</th>
            <th class="px-6 py-3 text-left">Amount</th>
            <th class="px-6 py-3 text-left">Status</th>
            <th class="px-6 py-3 text-left">Order Date</th>
            <th class="px-6 py-3 text-left">Return Date</th>
            <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-300">
        <?php while ($order = $result->fetch_assoc()): ?>
        <tr class="bg-white hover:bg-gray-100">
            <td class="px-6 py-4 font-semibold text-blue-700">#<?= $order['id']; ?></td>
            <td class="px-6 py-4 text-sm font-semibold text-gray-700"><?= $order['product_id']; ?></td>
            <td class="px-6 py-4 font-medium"><?= $order['customer_name']; ?></td>
            <td class="px-6 py-4 text-sm text-gray-600"><?= $order['phone']; ?></td>
            <td class="px-6 py-4 text-sm text-gray-600"><?= $order['alt_phone']; ?></td>
            <td class="px-6 py-4 text-sm text-gray-600"><?= $order['email']; ?></td>
            <td class="px-6 py-4 text-sm"><?= $order['product_name']; ?></td>
            <td class="px-6 py-4 font-semibold text-red-600">₹<?= number_format($order['total_amount'], 2); ?></td>
            <td class="px-6 py-4">
                <select name="status" class="px-3 py-1 border rounded-lg bg-gray-100 text-gray-700 status-dropdown" 
                    data-order-id="<?= $order['id']; ?>">
                    <?php
                    $statuses = ['Pending', 'Completed', 'Cancelled', 'Rented', 'Return', 'Laundry'];
                    foreach ($statuses as $status) {
                        $selected = ($order['status'] === $status) ? 'selected' : '';
                        echo "<option value='$status' $selected>$status</option>";
                    }
                    ?>
                </select>
            </td>
            <td class="px-6 py-4 text-sm text-gray-600"><?= $order['order_date']; ?></td>
            <td class="px-6 py-4 text-sm text-gray-600"><?= $order['return_date']; ?></td>
            <td class="px-6 py-4">
                <a href="complate_details_order.php?id=<?= $order['id']; ?>" class="text-blue-600 font-semibold hover:underline">View</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
