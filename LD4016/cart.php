<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Delicious Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the dynamic header -->
    
    <main class="cart-container">
        <h2 class="cart-title">Order Details</h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $item => $details): ?>
                <div class="cart-item">
                    <div class="item-details">
                        <?php if (strpos($item, 'custom_pizza_') === 0): ?>
                            <div class="custom-pizza-details">
                                <span class="item-name">Custom Pizza</span>
                                <div class="ingredients-list">
                                    <small>Base: <?php echo htmlspecialchars($details['details']['base']); ?></small><br>
                                    <?php if (!empty($details['details']['cheeses'])): ?>
                                        <small>Cheeses: <?php echo implode(', ', array_map('htmlspecialchars', $details['details']['cheeses'])); ?></small><br>
                                    <?php endif; ?>
                                    <?php if (!empty($details['details']['meats'])): ?>
                                        <small>Meats: <?php echo implode(', ', array_map('htmlspecialchars', $details['details']['meats'])); ?></small><br>
                                    <?php endif; ?>
                                    <?php if (!empty($details['details']['vegetables'])): ?>
                                        <small>Vegetables: <?php echo implode(', ', array_map('htmlspecialchars', $details['details']['vegetables'])); ?></small><br>
                                    <?php endif; ?>
                                    <?php if (!empty($details['details']['toppings'])): ?>
                                        <small>Toppings: <?php echo implode(', ', array_map('htmlspecialchars', $details['details']['toppings'])); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <span class="item-name"><?php echo htmlspecialchars($item); ?></span>
                        <?php endif; ?>
                        <div class="quantity-controls">
                            <button class="quantity-btn decrement" data-item="<?php echo htmlspecialchars($item); ?>">-</button>
                            <span class="quantity"><?php echo $details['quantity']; ?></span>
                            <button class="quantity-btn increment" data-item="<?php echo htmlspecialchars($item); ?>">+</button>
                        </div>
                    </div>
                    <div class="item-price-box">
                        <span class="item-price" data-unit-price="<?php echo htmlspecialchars($details['price']); ?>">
                            £<?php echo number_format($details['price'] * $details['quantity'], 2); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <div class="cart-summary">
            <div class="subtotal">
                <span>Subtotal</span>
                <span>£<?php echo number_format(array_sum(array_map(function ($item) {
                    return $item['price'] * $item['quantity'];
                }, $_SESSION['cart'])), 2); ?></span>
            </div>
            <div class="coupon">
                <input type="text" placeholder="Have a coupon?">
            </div>
            <div class="vat">
                <span>+20% VAT</span>
                <span>£<?php echo number_format(array_sum(array_map(function ($item) {
                    return $item['price'] * $item['quantity'];
                }, $_SESSION['cart'])) * 0.2, 2); ?></span>
            </div>
            <div class="total">
                <span>Order Total:</span>
                <span>£<?php echo number_format(array_sum(array_map(function ($item) {
                    return $item['price'] * $item['quantity'];
                }, $_SESSION['cart'])) * 1.2, 2); ?></span>
            </div>
        </div>

        <button class="checkout-btn">Proceed to Checkout</button>
    </main>

    <!-- Embed the script defining `isUserSignedIn` before `cart.js` -->
    <script>
    // Embed PHP inside JavaScript to pass user sign-in status
    let isUserSignedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    </script>
    <script src="cart.js"></script> <!-- Load the cart.js after defining `isUserSignedIn` -->

    <!-- Empty Cart Modal -->
    <div id="emptyCartModal" class="empty-cart-modal">
        <div class="empty-cart-modal-content">
            <div class="empty-cart-modal-header">
                <span class="close-empty-cart-modal">&times;</span>
                <h2>Cart is Empty</h2>
            </div>
            <p>Please add some items from the menu to proceed.</p>
            <button class="close-empty-cart-btn">Close</button>
        </div>
    </div>

    <!-- Sign-In Modal -->
    <div id="authModal" class="auth-modal">
        <div class="auth-modal-content">
            <div class="auth-modal-header">
                <span class="close-auth-modal">&times;</span>
                <h2 id="authModalTitle">Sign in to Proceed to Checkout</h2>
            </div>
            <div class="auth-modal-body" id="authModalBody">
                <div class="auth-section" id="signInSection">
                    <h3>Enter your log-in credentials to proceed to checkout</h3>
                    <form id="signInForm">
                        <input type="text" name="username" placeholder="Username / E-mail address" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="button" class="auth-btn" onclick="handleLogin()">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for AJAX login -->
    <script>
        function handleLogin() {
            const form = document.getElementById('signInForm');
            const formData = new FormData(form);

            // AJAX request to login.php
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    isUserSignedIn = true; // Update the signed-in status
                    document.getElementById('authModal').style.display = 'none'; // Close the sign-in modal

                    // Update the UI for the dropdown to show "Logout"
                    document.querySelector('.my-account .sign-in-btn').textContent = 'Logout';
                    document.querySelector('.my-account .sign-in-btn').classList.add('logout-btn');
                    document.querySelector('.my-account .sign-in-btn').classList.remove('sign-in-btn');
                    
                    // Optionally redirect to the checkout page
                    window.location.href = 'checkout.php';
                } else {
                    alert('Login failed. Please check your credentials and try again.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Event listener for the checkout button
        document.querySelector('.checkout-btn').addEventListener('click', function() {
            // Check if the cart is empty
            const cartIsEmpty = document.querySelectorAll('.cart-item').length === 0;

            if (cartIsEmpty) {
                // Show the empty cart modal if the cart is empty
                document.getElementById('emptyCartModal').style.display = 'block';
            } else if (!isUserSignedIn) {
                // Show the sign-in modal if the user is not signed in
                document.getElementById('authModal').style.display = 'block';
            } else {
                // Proceed to the checkout page
                window.location.href = 'checkout.php';
            }
        });

        // Close modal functionality
        document.querySelector('.close-empty-cart-modal').addEventListener('click', function() {
            document.getElementById('emptyCartModal').style.display = 'none';
        });
        document.querySelector('.close-empty-cart-btn').addEventListener('click', function() {
            document.getElementById('emptyCartModal').style.display = 'none';
        });
        document.querySelector('.close-auth-modal').addEventListener('click', function() {
            document.getElementById('authModal').style.display = 'none';
        });
    </script>

    <?php include 'footer.php'; ?>

</body>
</html>
