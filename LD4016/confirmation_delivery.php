<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Delicious Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the dynamic header -->

    <main class="confirmation-container">
        <div class="order-placed">
            <img src="images/check-icon.png" alt="Order Placed" class="confirmation-icon">
            <h2>Order placed</h2>
        </div>

        <div class="order-status">
            <h3>Order Status:</h3>
            <div class="status-steps">
                <div class="status-step">
                    <img src="images/restaurant-accepted.png" alt="Restaurant Accepted">
                    <p>Restaurant has accepted your order</p>
                </div>
                <div class="status-circle" id="circle1"></div>
                <div class="status-step">
                    <img src="images/order-preparing.png" alt="Order Preparing">
                    <p>Your order is being prepared</p>
                </div>
                <div class="status-circle" id="circle2"></div>
                <div class="status-step">
                    <img src="images/order-ready1.png" alt="Order Ready1">
                    <p>Your order is on its way</p>
                </div>
                <div class="status-circle" id="circle3"></div>
                <div class="status-step">
                    <img src="images/order-picked.png" alt="Order Picked">
                    <p>Order delivered</p>
                </div>
            </div>
        </div>


        <div class="help-section">
            <h3>Need help with your order?</h3>
            <a href="contactus.php" class="contact-btn">Contact us</a>
        </div>
    </main>
</body>
<script src="orderStatus.js"></script>
<?php include 'footer.php'; ?>

</html>
