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
    <header>
        <!-- Include the same header used on your other pages -->
    </header>

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
                                        <small>Toppings: <?php echo implode(', ', array_map('htmlspecialchars', $details['details']['toppings'])); ?></small><br>
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

    <script src="cart.js"></script>
</body>
</html>
