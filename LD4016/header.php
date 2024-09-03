<?php
session_start(); // Start session to access session variables
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious Pizza</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <!-- Correct Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin'): ?>
        <!-- Admin-specific header -->
        <header>
            <a href="index.php">
                <img src="images/logo.jpg" alt="Delicious Pizza Logo" class="logo">
            </a>
            <nav>
                <ul>
                    <li><a href="new_orders.php">New Orders</a></li>
                    <li><a href="current_orders.php">Current Orders</a></li>
                    <li><a href="previous_orders.php">Previous Orders</a></li>
                    <li><a href="my_account.php">My Account</a></li>
                </ul>
            </nav>
        </header>
    <?php else: ?>
        <!-- Regular user header -->
        <header>
            <a href="index.php">
                <img src="images/logo.jpg" alt="Delicious Pizza Logo" class="logo">
            </a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php#about-us-section">About Us</a></li>
                    <li><a href="menu.php">Order</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                    <li class="my-account">
                        <a href="#">My account</a>
                        <div class="account-dropdown">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="#" class="logout-btn" style="background-color: red; color: white;">Logout</a>
                            <?php else: ?>
                                <a href="#" class="sign-in-btn">Sign in</a>
                            <?php endif; ?>
                            <a href="customerPrevious_orders.php">Previous orders</a>
                            <a href="#">Address editor</a>
                            <a href="#">Support Tickets</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Cart Icon -->
            <div class="cart-icon">
                <a href="cart.php">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
        </header>
    <?php endif; ?>

    <script>
        // Ensure logout confirmation and sign-in state management
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.querySelector('.logout-btn');
            const signInBtn = document.querySelector('.sign-in-btn');
            const authModal = document.getElementById('authModal');

            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to log out?')) {
                        window.location.href = 'logout.php';
                    }
                });
            }

            if (signInBtn) {
                signInBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    authModal.style.display = 'block';
                });
            }
        });
    </script>
</body>

<script src="dropdown.js"></script>

</html>
