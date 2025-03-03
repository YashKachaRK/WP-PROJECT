<?php
session_start();


include_once("templates/nav.php");
// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if product details are passed in the URL
if (isset($_GET['name'], $_GET['price'], $_GET['type'], $_GET['image'])) {
    $product = [
        'name'  => $_GET['name'],
        'price' => $_GET['price'],
        'type'  => $_GET['type'],
        'image' => $_GET['image']
    ];

    // Add product to cart session
    $_SESSION['cart'][] = $product;
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    unset($_SESSION['cart'][$removeIndex]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
}

// Clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .cart-table th, .cart-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .cart-table th {
            background: #ff6f00;
            color: white;
            font-size: 16px;
        }
        .cart-table img {
            width: 80px;
            border-radius: 10px;
        }
        .price {
            font-weight: bold;
            color: #B12704;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s ease;
        }
        .btn-remove {
            background: #ff3333;
            color: white;
        }
        .btn-remove:hover {
            background: #cc0000;
        }
        .btn-clear {
            background: #555;
            color: white;
        }
        .btn-clear:hover {
            background: #333;
        }
        .btn-back {
            background: #007bff;
            color: white;
        }
        .btn-back:hover {
            background: #0056b3;
        }
        .empty-cart {
            color: #777;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container" class="bg-gray-100">
    <h1>Your Shopping Cart</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="cart-table">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['type']); ?></td>
                    <td class="price">₹<?php echo number_format($item['price']); ?></td>
                    <td>
                        <a href="cart.php?remove=<?php echo $index; ?>" class="btn btn-remove">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="cart.php?clear=true" class="btn btn-clear">Clear Cart</a>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>

    <br><br>
    <a href="index.php" class="btn btn-back">Continue Shopping</a>
</div>

</body>
</html>
