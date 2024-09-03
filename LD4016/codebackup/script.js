document.addEventListener('DOMContentLoaded', function() {
    // Separate function to handle menu page logic
    handleMenuPage();

    // Separate function to handle cart page logic
    handleCartPage();

    function handleMenuPage() {
        attachAddToCartListenersMenu();

        function attachAddToCartListenersMenu() {
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemName = button.dataset.id;
                    const price = button.dataset.price;

                    // AJAX request to add the item to the cart
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_cart.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                transformButtonToQuantitySelectorMenu(button, itemName, price);
                            }
                        }
                    };
                    xhr.send(`action=add&item=${encodeURIComponent(itemName)}&quantity=1&price=${encodeURIComponent(price)}`);
                });
            });

            document.querySelectorAll('.quantity-controls .increment').forEach(button => {
                button.addEventListener('click', handleMenuQuantityChange);
            });

            document.querySelectorAll('.quantity-controls .decrement').forEach(button => {
                button.addEventListener('click', handleMenuQuantityChange);
            });
        }

        function transformButtonToQuantitySelectorMenu(button, itemName, price) {
            button.outerHTML = `
                <div class="quantity-controls">
                    <button class="quantity-btn decrement" data-item="${itemName}" data-price="${price}">
                        <span class="icon">🗑️</span>
                    </button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn increment" data-item="${itemName}" data-price="${price}">+</button>
                </div>
            `;

            document.querySelector(`.quantity-controls .decrement[data-item="${itemName}"]`).addEventListener('click', handleMenuQuantityChange);
            document.querySelector(`.quantity-controls .increment[data-item="${itemName}"]`).addEventListener('click', handleMenuQuantityChange);
        }

        function handleMenuQuantityChange(event) {
            const button = event.currentTarget;
            const itemName = button.dataset.item;
            const price = button.dataset.price;
            const quantityElement = button.parentElement.querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (button.classList.contains('increment')) {
                quantity++;
            } else if (button.classList.contains('decrement')) {
                if (quantity > 1) {
                    quantity--;
                } else {
                    button.parentElement.parentElement.innerHTML = `
                        <button class="add-to-cart-btn" data-id="${itemName}" data-price="${price}">Add to cart</button>
                    `;
                    attachAddToCartListenersMenu(); // Reattach the event listener to the new button
                    return;
                }
            }

            const decrementButton = button.parentElement.querySelector('.decrement .icon');
            if (quantity > 1) {
                decrementButton.textContent = '-';
            } else {
                decrementButton.textContent = '🗑️';
            }

            quantityElement.textContent = quantity;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(`action=update&item=${encodeURIComponent(itemName)}&quantity=${encodeURIComponent(quantity)}`);
        }
    }

    function handleCartPage() {
        attachCartQuantityListeners();

        function attachCartQuantityListeners() {
            document.querySelectorAll('.cart-container .quantity-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const isIncrement = button.classList.contains('increment');
                    const quantityElement = button.parentElement.querySelector('.quantity');
                    let currentQuantity = parseInt(quantityElement.textContent);
                    const itemName = button.dataset.item;

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

                    if (currentQuantity > 0) {
                        quantityElement.textContent = currentQuantity;
                    }

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
                const quantity = parseInt(item.querySelector('.quantity').textContent);
                const price = parseFloat(item.querySelector('.item-price').textContent.replace('£', '')) / quantity;
                subtotal += price * quantity;
            });

            const vat = subtotal * 0.2; // 20% VAT
            const total = subtotal + vat;

            document.querySelector('.subtotal span:last-child').textContent = `£${subtotal.toFixed(2)}`;
            document.querySelector('.vat span:last-child').textContent = `£${vat.toFixed(2)}`;
            document.querySelector('.total span:last-child').textContent = `£${total.toFixed(2)}`;
        }
    }
});
