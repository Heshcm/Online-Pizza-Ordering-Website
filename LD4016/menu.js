document.addEventListener('DOMContentLoaded', function() {
    attachAddToCartListenersMenu();

    // Function to open the Create Pizza popup
    window.openCreatePizzaPopup = function() {
        document.getElementById('createPizzaPopup').style.display = 'block';
    };

    // Function to close the Create Pizza popup
    window.closeCreatePizzaPopup = function() {
        document.getElementById('createPizzaPopup').style.display = 'none';
    };

    // Function to submit the Create Your Own Pizza form
    window.submitCreatePizza = function() {
        const selectedBase = document.querySelector('input[name="base"]:checked');
        const selectedCheeses = Array.from(document.querySelectorAll('input[name="cheese[]"]:checked')).map(checkbox => checkbox.value);
        const selectedMeats = Array.from(document.querySelectorAll('input[name="meat[]"]:checked')).map(checkbox => checkbox.value);
        const selectedVegetables = Array.from(document.querySelectorAll('input[name="vegetables[]"]:checked')).map(checkbox => checkbox.value);
        const selectedToppings = Array.from(document.querySelectorAll('input[name="toppings[]"]:checked')).map(checkbox => checkbox.value);
    
        if (!selectedBase) {
            alert('Please select a base!');
            return;
        }
    
        const pizzaDetails = {
            base: selectedBase.value,
            cheeses: selectedCheeses,
            meats: selectedMeats,
            vegetables: selectedVegetables,
            toppings: selectedToppings
        };
    
        // Send the custom pizza details to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                closeCreatePizzaPopup();
                alert('Custom pizza added to cart!');
                // Optionally, update the cart UI here
            }
        };
        xhr.send(`action=add_custom&item=Create Your Own Pizza&details=${encodeURIComponent(JSON.stringify(pizzaDetails))}&quantity=1`);
    };

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
                            // Transform the button into a quantity selector
                            transformButtonToQuantitySelector(button, itemName, price);
                        }
                    }
                };
                xhr.send(`action=add&item=${encodeURIComponent(itemName)}&quantity=1&price=${encodeURIComponent(price)}`);
            });
        });
    }

    function transformButtonToQuantitySelector(button, itemName, price) {
        button.outerHTML = `
            <div class="quantity-controls">
                <button class="quantity-btn decrement" data-item="${itemName}" data-price="${price}">
                    <span class="icon">🗑️</span>
                </button>
                <span class="quantity">1</span>
                <button class="quantity-btn increment" data-item="${itemName}" data-price="${price}">+</button>
            </div>
        `;

        document.querySelector(`.quantity-controls .decrement[data-item="${itemName}"]`).addEventListener('click', handleQuantityChange);
        document.querySelector(`.quantity-controls .increment[data-item="${itemName}"]`).addEventListener('click', handleQuantityChange);
    }

    function handleQuantityChange(event) {
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
                document.querySelector(`.add-to-cart-btn[data-id="${itemName}"]`).addEventListener('click', function() {
                    transformButtonToQuantitySelector(button, itemName, price);
                });
                return;
            }
        }

        // Update the icon based on quantity
        const decrementButton = button.parentElement.querySelector('.decrement .icon');
        if (quantity > 1) {
            decrementButton.textContent = '-';
        } else {
            decrementButton.textContent = '🗑️';
        }

        // Update the displayed quantity
        quantityElement.textContent = quantity;

        // Update the quantity in the cart via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`action=update&item=${encodeURIComponent(itemName)}&quantity=${encodeURIComponent(quantity)}`);
    }

    function attachQuantityControlListeners() {
        // Handle quantity adjustments in the cart page if needed
        document.querySelectorAll('.quantity-btn').forEach(button => {
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
                    currentQuantity = 0;
                }

                if (currentQuantity > 0) {
                    quantityElement.textContent = currentQuantity;
                }

                // Update the quantity in the session via AJAX
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "update_cart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        updateCartSummary(); // Update the cart summary
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

    attachQuantityControlListeners(); // Attach listeners for the cart page
});
// menu.js
document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.getElementById('searchButton');
    const searchInput = document.getElementById('ingredientSearch');

    searchButton.addEventListener('click', function () {
        const ingredient = searchInput.value.trim();

        if (ingredient) {
            fetch(`search_pizzas.php?ingredient=${encodeURIComponent(ingredient)}`)
                .then(response => response.json())
                .then(data => {
                    displayPizzas(data);
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('Please enter an ingredient to search.');
        }
    });

    function displayPizzas(pizzas) {
        const menuGrid = document.querySelector('.menu-grid');
        menuGrid.innerHTML = ''; // Clear existing pizzas

        if (pizzas.length > 0) {
            pizzas.forEach(pizza => {
                const pizzaItem = document.createElement('div');
                pizzaItem.classList.add('menu-item');
                pizzaItem.innerHTML = `
                    <img src="${pizza.image}" alt="${pizza.name}">
                    <h3>${pizza.name}</h3>
                    <p>${pizza.description}</p>
                    <span class="price">£${pizza.price.toFixed(2)}</span>
                `;
                menuGrid.appendChild(pizzaItem);
            });
        } else {
            menuGrid.innerHTML = '<p>No pizzas found with that ingredient.</p>';
        }
    }
});
