<?php
// Database Connection
$host = "localhost"; // Change if needed
$user = "root"; // Change if needed
$password = ""; // Change if needed
$database = "final"; // Your database name

$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $category = $_POST["category"];
    $gender = $_POST["gender"];
    $rental_price = $_POST["rental_price"];
    $availability = $_POST["availability"];

    // Handle Image Upload
    $image_path = "";
    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = $target_dir . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_path);
    }

    // Insert into Database
    $stmt = $conn->prepare("INSERT INTO products (product_name, category, gender, rental_price, availability, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $product_name, $category, $gender, $rental_price, $availability, $image_path);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href = 'add_product.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
