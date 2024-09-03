<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Delicious Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the dynamic header -->

    <main class="checkout-container">
        <h2 class="checkout-title">Checkout</h2>

        <!-- Step 1: Delivery or Pickup -->
        <div class="checkout-step">
            <h3>Would you like your order to be delivered or picked up?</h3>
            <div class="option-buttons">
                <button class="option-btn" id="pickupBtn">Pick Up</button>
                <button class="option-btn" id="deliveryBtn">Delivery</button>
            </div>
        </div>

        <!-- Step 2: Delivery Address (appears only if Delivery is selected) -->
        <div id="deliveryAddress" class="hidden">
            <h3>Delivery Address</h3>
            <form id="addressForm">
                <input type="text" id="streetAddress" name="address" placeholder="Street Address" required>
                <input type="text" id="city" name="city" placeholder="City" required>
                <input type="text" id="postcode" name="postcode" placeholder="Postcode" required>
                <button type="button" class="proceed-btn" id="proceedToPaymentBtn">Proceed to Payment</button>
            </form>
        </div>

        <!-- Step 3: Payment (appears after "Proceed to Payment" is clicked) -->
        <div id="paymentDetails" class="hidden">
            <h3>Payment Details</h3>
            <form id="paymentForm" method="POST">
                <input type="text" name="cardName" placeholder="Name on Card" required>
                <input type="text" name="cardNumber" placeholder="Card Number" required>
                <input type="text" name="expiryDate" placeholder="Expiry Date (MM/YY)" required>
                <input type="text" name="cvv" placeholder="CVV" required>
                <button type="button" class="checkout-btn" id="checkoutBtn">Checkout</button>
            </form>
        </div>
    </main>

    <script>
        let isDelivery = false; // Track selected option (delivery or pickup)

        // Show or hide address and payment forms based on user selection
        document.getElementById('deliveryBtn').addEventListener('click', function() {
            document.getElementById('deliveryAddress').classList.remove('hidden');
            document.getElementById('paymentDetails').classList.add('hidden');
            isDelivery = true;
        });

        document.getElementById('pickupBtn').addEventListener('click', function() {
            document.getElementById('deliveryAddress').classList.add('hidden');
            document.getElementById('paymentDetails').classList.remove('hidden');
            isDelivery = false;
        });

        // Proceed to payment after entering delivery details
        document.getElementById('proceedToPaymentBtn').addEventListener('click', function() {
            const street = document.getElementById('streetAddress').value;
            const city = document.getElementById('city').value;
            const postcode = document.getElementById('postcode').value;

            // Validate address fields
            if (street && city && postcode) {
                document.getElementById('paymentDetails').classList.remove('hidden');
            } else {
                alert('Please fill in all the address fields before proceeding to payment.');
            }
        });

        // Handle the checkout button click
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const paymentForm = document.getElementById('paymentForm');
            const formData = new FormData(paymentForm);

            // Add delivery or pickup address
            if (isDelivery) {
                const street = document.getElementById('streetAddress').value;
                const city = document.getElementById('city').value;
                const postcode = document.getElementById('postcode').value;
                formData.append('delivery_address', `${street}, ${city}, ${postcode}`);
            } else {
                formData.append('delivery_address', 'Pickup');
            }

            // AJAX request to save the order
            fetch('save_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Empty the cart after a successful order
                    clearCart();

                    // Redirect to the appropriate confirmation page
                    if (isDelivery) {
                        window.location.href = 'confirmation_delivery.php';
                    } else {
                        window.location.href = 'confirmation_pickup.php';
                    }
                } else {
                    alert(data.message || 'Error: Unable to process the order.');
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Function to clear the cart after placing an order
        function clearCart() {
            fetch('empty_cart.php', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        console.warn('Cart could not be cleared properly.');
                    }
                })
                .catch(error => console.error('Error clearing the cart:', error));
        }

    </script>
    <?php include 'footer.php'; ?>

</body>
</html>
