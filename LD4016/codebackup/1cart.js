document.addEventListener('DOMContentLoaded', function() {
    attachCartQuantityListeners();

    function attachCartQuantityListeners() {
        document.querySelectorAll('.cart-container .quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
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
});
