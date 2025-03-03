<?php
include 'asset/db_connection.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT full_name FROM users_register WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
  } 
?>
 <!-- Font Awesome for Icons -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Tailwind CSS (Required for Preline) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Preline CSS -->
  <script src="https://unpkg.com/preline@latest/dist/preline.js"></script>

  <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

<style>
    nav {
        z-index: 10;
        /* Ensures nav stays above other content */
    }

    width: 100%;
    padding-top: 10px;
    }

    #mobileMenu a {
        text-decoration: none;
        padding: 10px;
        display: block;
    }

    #profileDropdown .hs-dropdown-menu {
        z-index: 20;
        /* Ensure the dropdown appears above content */
    }

    @media (max-width: 768px) {

        /* Adjust mobile menu styling */
        .hidden.md:flex {
            display: none !important;
        }

        #mobileMenu {
            display: block;
            background-color: #ffffff;
            width: 100%;
            padding-top: 10px;
        }

        /* Ensure mobile buttons don't overlap */
        .buttons {
            display: none;
        }
    }
</style>

<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="index.php" class="text-black text-2xl font-bold flex items-center">
                    RentWear
                </a>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="index.php" class="text-black font-medium hover:text-gray-600"><i class="fas fa-home"></i>
                    Home</a>
                <a href="collection.php" class="text-black font-medium hover:text-gray-600"><i
                        class="fas fa-tshirt"></i>Collection</a>
                <a href="cart.php" class="text-black font-medium hover:text-gray-600"><i class="fas fa-heart"></i>
                    Cart</a>
                <a href="booked.php" class="text-black font-medium hover:text-gray-600"><i
                        class="fas fa-shopping-cart"></i> Booked</a>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden md:flex items-center space-x-4">
                <div class="hs-dropdown relative">
                    <button id="profileDropdown" type="button"
                        class="flex items-center text-black font-medium space-x-2">
                        <img src="img/profile.png" alt="Profile" class="w-9 h-9 rounded-full" />
                        <span>My Account</span>
                        <?php if (isset($user)): ?>
                            <span> - <?php echo htmlspecialchars($user['full_name']); ?></span>
                        <?php endif; ?>
                    </button>

                    <div class="hs-dropdown-menu absolute right-0 hidden w-44 bg-white rounded-md shadow-md py-2 z-10">
                        <a href="profile.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100"><i
                                class="fas fa-user"></i> Profile</a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-black focus:outline-none" id="mobileMenuButton">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg">
        <a href="index.php" class="block px-4 py-2 text-black hover:bg-gray-100"><i class="fas fa-home"></i> Home</a>
        <a href="collection.php" class="block px-4 py-2 text-black hover:bg-gray-100"><i
                class="fas fa-tshirt"></i> Collection</a>
        <a href="whis.php" class="block px-4 py-2 text-black hover:bg-gray-100"><i class="fas fa-heart"></i>
            Wishlist</a>
        <a href="booked.php" class="block px-4 py-2 text-black hover:bg-gray-100"><i class="fas fa-shopping-cart"></i>
            Booked</a>
        <hr />
        <a href="profile.php" class="block px-4 py-2 text-black hover:bg-gray-100"><i class="fas fa-user"></i>
            Profile</a>
        <a href="login_user.php" class="block px-4 py-2 text-black hover:bg-gray-100"><i class="fas fa-sign-in-alt"></i>
            Login</a>
        <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100"><i class="fas fa-sign-out-alt"></i>
            Logout</a>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document
      .getElementById("mobileMenuButton")
      .addEventListener("click", function () {
        document.getElementById("mobileMenu").classList.toggle("hidden");
      });
  </script>