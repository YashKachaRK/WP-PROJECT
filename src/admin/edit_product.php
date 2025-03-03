<?php
// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "final";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get Product ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = [];

if ($id > 0) {
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $gender = $_POST['gender'];
    $rental_price = $_POST['rental_price'];
    $availability = $_POST['availability'];
    $image = $product['image']; // Default to existing image

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Allowed file types
        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Only JPG, JPEG, and PNG files are allowed.");
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Delete old image if a new one is uploaded
            if (!empty($product['image']) && file_exists($product['image'])) {
                unlink($product['image']);
            }
            $image = $target_file; // Update image path
        } else {
            die("Error uploading image.");
        }
    }

    // Update product in the database
    $update_sql = "UPDATE products SET product_name='$product_name', category='$category', gender='$gender', rental_price='$rental_price', availability='$availability', image='$image' WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Product updated successfully!'); window.location='show_all_product.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-4">Edit Product</h1>
    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
        <label class="block font-semibold">Product Name:</label>
        <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required class="w-full border p-2 rounded mb-4">
        
        <label class="block font-semibold">Category:</label>
        <input type="text" name="category" value="<?= $product['category'] ?>" required class="w-full border p-2 rounded mb-4">
        
        <label class="block font-semibold">Gender:</label>
        <select name="gender" required class="w-full border p-2 rounded mb-4">
            <option value="Male" <?= $product['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $product['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        </select>

        <label class="block font-semibold">Rental Price:</label>
        <input type="number" name="rental_price" value="<?= $product['rental_price'] ?>" required class="w-full border p-2 rounded mb-4">
        
        <label class="block font-semibold">Availability:</label>
        <select name="availability" required class="w-full border p-2 rounded mb-4">
            <option value="Available" <?= $product['availability'] == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Rented" <?= $product['availability'] == 'Rented' ? 'selected' : '' ?>>Rented</option>
        </select>

        <!-- Display Existing Image -->
        <label class="block font-semibold">Current Image:</label>
        <img src="<?= $product['image'] ?>" alt="Product Image" class="w-32 h-32 object-cover mb-4 border">

        <!-- Upload New Image -->
        <label class="block font-semibold">Change Image:</label>
        <input type="file" name="image" class="w-full border p-2 rounded mb-4">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Save Changes</button>
        <a href="show_all_product.php" class="text-red-500 ml-4">Cancel</a>
    </form>
</body>
</html>
