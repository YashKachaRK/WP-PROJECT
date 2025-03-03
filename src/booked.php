<?php
session_start();

// Initialize booked items if not set
if (!isset($_SESSION['booked'])) {
    $_SESSION['booked'] = [];
}

// Check if product details are passed in the URL
if (isset($_GET['name'], $_GET['price'], $_GET['type'], $_GET['image'])) {
    $product = [
        'name'  => $_GET['name'],
        'price' => $_GET['price'],
        'type'  => $_GET['type'],
        'image' => $_GET['image']
    ];

    // Add product to booked session
    $_SESSION['booked'][] = $product;

    // Redirect before any output
    header("Location: booked.php");
    exit();
}

// Remove item from booked list
if (isset($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    unset($_SESSION['booked'][$removeIndex]);
    $_SESSION['booked'] = array_values($_SESSION['booked']); // Re-index the array
    header("Location: booked.php");
    exit();
}

// Clear booked items
if (isset($_GET['clear'])) {
    $_SESSION['booked'] = [];
    header("Location: booked.php");
    exit();
}
?>
<?php
include_once("templates/nav.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Your Booked Items</h1>

        <?php if (!empty($_SESSION['booked'])): ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-orange-500 text-white">
                            <th class="px-4 py-3 text-left">Image</th>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Type</th>
                            <th class="px-4 py-3 text-left">Price</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['booked'] as $index => $item): ?>
                            <tr class="border-b border-gray-300">
                                <td class="px-4 py-3"><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product" class="w-16 h-16 rounded-md"></td>
                                <td class="px-4 py-3 font-medium"><?php echo htmlspecialchars($item['name']); ?></td>
                                <td class="px-4 py-3"><?php echo htmlspecialchars($item['type']); ?></td>
                                <td class="px-4 py-3 text-red-500 font-semibold">₹<?php echo number_format($item['price']); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <a href="booked.php?remove=<?php echo $index; ?>" class="text-white bg-red-500 hover:bg-red-600 px-3 py-2 rounded-md">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-between">
                <a href="booked.php?clear=true" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-800">Clear Booked Items</a>
                <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Continue Shopping</a>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-lg text-center mt-6">No items booked yet.</p>
            <div class="text-center mt-4">
                <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
