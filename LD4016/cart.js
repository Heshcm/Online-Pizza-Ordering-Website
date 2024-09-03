document.addEventListener('DOMContentLoaded', function () {
    attachCartQuantityListeners();

    function attachCartQuantityListeners() {
        document.querySelectorAll('.cart-container .quantity-btn').forEach(button => {
            button.addEventListener('click', function () {
                const isIncrement = button.classList.contains('increment');
                const quantityElement = button.parentElement.querySelector('.quantity');
                let currentQuantity = parseInt(quantityElement.textContent);
                const itemName = button.dataset.item;
                const priceElement = button.closest('.cart-item').querySelector('.item-price');
                const unitPrice = parseFloat(priceElement.dataset.unitPrice); // Original price per item

                // Adjust the quantity
                if (isIncrement) {
                    currentQuantity++;
                } else if (currentQuantity > 1) {
                    currentQuantity--;
                } else if (currentQuantity === 1 && !isIncrement) {
                    const cartItem = button.closest('.cart-item');
                    cartItem.parentNode.removeChild(cartItem);

                    // Send request to remove the item from the cart
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_cart.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            updateCartSummary();
                        }
                    };
                    xhr.send(`action=update&item=${encodeURIComponent(itemName)}&quantity=0`);
                    return;
                }

                // Update the quantity display
                quantityElement.textContent = currentQuantity;

                // Update the price in the DOM
                const updatedPrice = (unitPrice * currentQuantity).toFixed(2);
                priceElement.textContent = `£${updatedPrice}`;

                // Update the quantity in the session via AJAX
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "update_cart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        updateCartSummary();
                    }
                };
                xhr.send(`action=update&item=${encodeURIComponent(itemName)}&quantity=${encodeURIComponent(currentQuantity)}`);
            });
        });
    }

    function updateCartSummary() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const priceElement = item.querySelector('.item-price');
            const price = parseFloat(priceElement.textContent.replace('£', ''));
            subtotal += price;
        });

        const vat = subtotal * 0.2; // 20% VAT
        const total = subtotal + vat;

        document.querySelector('.subtotal span:last-child').textContent = `£${subtotal.toFixed(2)}`;
        document.querySelector('.vat span:last-child').textContent = `£${vat.toFixed(2)}`;
        document.querySelector('.total span:last-child').textContent = `£${total.toFixed(2)}`;
    }

    // Function to handle checkout
    function handleCheckout() {
        const cartIsEmpty = document.querySelectorAll('.cart-item').length === 0;

        if (cartIsEmpty) {
            document.getElementById('emptyCartModal').style.display = 'block';
        } else if (!isUserSignedIn) {
            document.getElementById('authModal').style.display = 'block';
        } else {
            window.location.href = 'checkout.php';
        }
    }

    document.querySelector('.checkout-btn').addEventListener('click', handleCheckout);

    // Handle login process
    function handleLogin() {
        const form = document.getElementById('signInForm');
        const formData = new FormData(form);
    
        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                isUserSignedIn = true; // Update the signed-in status
                document.getElementById('authModal').style.display = 'none'; // Close the sign-in modal
                
                // Refresh the page to reflect the updated session state
                window.location.reload(); // This ensures that the session is updated immediately on the page
            } else {
                alert(data.error || 'Login failed. Please check your credentials and try again.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while logging in. Please try again.');
        });
    }
    

    // Attach login function to the sign-in button in the modal
    document.querySelector('.auth-btn').addEventListener('click', handleLogin);

    // Close modals
    document.querySelector('.close-empty-cart-modal').addEventListener('click', function () {
        document.getElementById('emptyCartModal').style.display = 'none';
    });
    document.querySelector('.close-empty-cart-btn').addEventListener('click', function () {
        document.getElementById('emptyCartModal').style.display = 'none';
    });
    document.querySelector('.close-auth-modal').addEventListener('click', function () {
        document.getElementById('authModal').style.display = 'none';
    });
});
