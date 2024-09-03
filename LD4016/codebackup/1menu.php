<?php
include 'delecious__pizza.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Delicious Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Use the same CSS file -->
</head>
<body>
    <header>
        <div class="logo"></div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="index.html#about-us-section">About Us</a></li>
                <li><a href="menu.php">Order</a></li>
                <li><a href="contactUs.html">Contact Us</a></li>
                <li><a href="#" class="my-account">My account</a></li>
            </ul>
        </nav>
    </header>

    <section class="menu-search">
        <input type="text" placeholder="Search for an item in the menu">
    </section>

    <!-- Pizzas Section -->
    <section class="menu-section">
        <h2>Pizza</h2>
        <div class="menu-grid">
            <?php foreach ($pizzas as $pizza): ?>
                <div class="menu-item">
                    <img src="<?php echo htmlspecialchars($pizza['image']); ?>" alt="<?php echo htmlspecialchars($pizza['name']); ?>">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($pizza['name']); ?></h3>
                        <span class="price">£<?php echo htmlspecialchars($pizza['price']); ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($pizza['description']); ?></p>

                    <div class="cart-control">
                        <?php 
                        $itemName = htmlspecialchars($pizza['name']);
                        if ($itemName === 'Create Your Own'): 
                        ?>
                            <button class="create-pizza-btn" onclick="openCreatePizzaPopup()">
                                Create
                            </button>
                        <?php else: ?>
                            <?php if (isset($_SESSION['cart'][$itemName])): 
                                $quantity = $_SESSION['cart'][$itemName]['quantity'];
                            ?>
                                <div class="quantity-controls">
                                    <button class="quantity-btn decrement" data-item="<?php echo $itemName; ?>" data-price="<?php echo htmlspecialchars($pizza['price']); ?>">
                                        <span class="icon"><?php echo $quantity > 1 ? '-' : '🗑️'; ?></span>
                                    </button>
                                    <span class="quantity"><?php echo $quantity; ?></span>
                                    <button class="quantity-btn increment" data-item="<?php echo $itemName; ?>" data-price="<?php echo htmlspecialchars($pizza['price']); ?>">+</button>
                                </div>
                            <?php else: ?>
                                <button class="add-to-cart-btn" 
                                        data-id="<?php echo $itemName; ?>" 
                                        data-price="<?php echo htmlspecialchars($pizza['price']); ?>">
                                    Add to cart
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Desserts Section -->
    <section class="menu-section">
        <h2>Dessert</h2>
        <div class="menu-grid-wide">
            <?php foreach ($desserts as $dessert): ?>
                <div class="menu-item wide-item">
                    <img src="<?php echo htmlspecialchars($dessert['image']); ?>" alt="<?php echo htmlspecialchars($dessert['name']); ?>">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($dessert['name']); ?></h3>
                        <span class="price">£<?php echo htmlspecialchars($dessert['price']); ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($dessert['description']); ?></p>

                    <div class="cart-control">
                        <?php 
                        $itemName = htmlspecialchars($dessert['name']);
                        if (isset($_SESSION['cart'][$itemName])): 
                            $quantity = $_SESSION['cart'][$itemName]['quantity'];
                        ?>
                            <div class="quantity-controls">
                                <button class="quantity-btn decrement" data-item="<?php echo $itemName; ?>" data-price="<?php echo htmlspecialchars($dessert['price']); ?>">
                                    <span class="icon"><?php echo $quantity > 1 ? '-' : '🗑️'; ?></span>
                                </button>
                                <span class="quantity"><?php echo $quantity; ?></span>
                                <button class="quantity-btn increment" data-item="<?php echo $itemName; ?>" data-price="<?php echo htmlspecialchars($dessert['price']); ?>">+</button>
                            </div>
                        <?php else: ?>
                            <button class="add-to-cart-btn" 
                                    data-id="<?php echo $itemName; ?>" 
                                    data-price="<?php echo htmlspecialchars($dessert['price']); ?>">
                                Add to cart
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Beverages Section -->
    <section class="menu-section">
        <h2>Beverages</h2>
        <div class="menu-grid">
            <?php foreach ($beverages as $beverage): ?>
                <div class="menu-item">
                    <img src="<?php echo htmlspecialchars($beverage['image']); ?>" alt="<?php echo htmlspecialchars($beverage['name']); ?>">
                    <div class="item-header">
                        <h3><?php echo htmlspecialchars($beverage['name']); ?></h3>
                        <span class="price">£<?php echo htmlspecialchars($beverage['price']); ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($beverage['description']); ?></p>

                    <div class="cart-control">
                        <?php 
                        $itemName = htmlspecialchars($beverage['name']);
                        if (isset($_SESSION['cart'][$itemName])): 
                            $quantity = $_SESSION['cart'][$itemName]['quantity'];
                        ?>
                            <div class="quantity-controls">
                                <button class="quantity-btn decrement" data-item="<?php echo $itemName; ?>" data-price="<?php echo htmlspecialchars($beverage['price']); ?>">
                                    <span class="icon"><?php echo $quantity > 1 ? '-' : '🗑️'; ?></span>
                                </button>
                                <span class="quantity"><?php echo $quantity; ?></span>
                                <button class="quantity-btn increment" data-item="<?php echo $itemName; ?>" data-price="<?php echo htmlspecialchars($beverage['price']); ?>">+</button>
                            </div>
                        <?php else: ?>
                            <button class="add-to-cart-btn" 
                                    data-id="<?php echo $itemName; ?>" 
                                    data-price="<?php echo htmlspecialchars($beverage['price']); ?>">
                                Add to cart
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Popup Structure for Create Your Own Pizza -->
    <!-- Popup Structure for Create Your Own Pizza -->
    <div id="createPizzaPopup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h3 class="popup-title">Create Your Own Pizza</h3>
                <span class="close" onclick="closeCreatePizzaPopup()">&times;</span>
            </div>

            <!-- Bases Section -->
            <h2 class="popup-selection-titles">Select Base:</h2>
            <div class="empty-box-container">
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/plainBase.jpg" alt="Plain Neapolitan Pizza Dough">
                        <label>
                            <input type="radio" name="base" value="Plain Neapolitan Pizza Dough" required>
                            Plain Neapolitan Pizza Dough
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/tomatoBase.jpg" alt="San Marzano Tomato Sauce">
                        <label>
                            <input type="radio" name="base" value="San Marzano Tomato Sauce" required>
                            San Marzano Tomato Sauce
                        </label>
                    </div>
                </div>
            </div>

            <!-- Cheeses Section -->
            <h2 class="popup-selection-titles">Select Cheese:</h2>
            <div class="empty-box-container">
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/mozzarellaCheese.jpg" alt="Fresh Mozzarella Cheese (Fior di Latte)">
                        <label>
                            <input type="checkbox" name="cheese[]" value="Fresh Mozzarella Cheese (Fior di Latte)">
                            Fresh Mozzarella Cheese (Fior di Latte)
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/burrataCheese.jpg" alt="Burrata Cheese">
                        <label>
                            <input type="checkbox" name="cheese[]" value="Burrata Cheese">
                            Burrata Cheese
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/parmigianoCheese.jpg" alt="Parmigiano Reggiano">
                        <label>
                            <input type="checkbox" name="cheese[]" value="Parmigiano Reggiano">
                            Parmigiano Reggiano
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/pecorinoCheese.jpg" alt="Pecorino Cheese">
                        <label>
                            <input type="checkbox" name="cheese[]" value="Pecorino Cheese">
                            Pecorino Cheese
                        </label>
                    </div>
                </div>
            </div>

            <!-- Meats Section -->
            <h2 class="popup-selection-titles">Select Meat:</h2>
            <div class="empty-box-container">
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/salamiMeat.jpg" alt="Italian Salami">
                        <label>
                            <input type="checkbox" name="meat[]" value="Italian Salami">
                            Italian Salami
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/sausageMeat.jpg" alt="Italian Sausage">
                        <label>
                            <input type="checkbox" name="meat[]" value="Italian Sausage">
                            Italian Sausage
                        </label>
                    </div>
                </div>
            </div>

            <!-- Vegetables Section -->
            <h2 class="popup-selection-titles">Select Vegetables:</h2>
            <div class="empty-box-container">
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/tomatoesVeg.jpg" alt="Cherry Tomatoes">
                        <label>
                            <input type="checkbox" name="vegetables[]" value="Cherry Tomatoes">
                            Cherry Tomatoes
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/garlicVeg.jpg" alt="Fresh Garlic">
                        <label>
                            <input type="checkbox" name="vegetables[]" value="Fresh Garlic">
                            Fresh Garlic
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/peppersVeg.jpg" alt="Chili Peppers">
                        <label>
                            <input type="checkbox" name="vegetables[]" value="Chili Peppers">
                            Chili Peppers
                        </label>
                    </div>
                </div>
            </div>

            <!-- Toppings Section -->
            <h2 class="popup-selection-titles">Select Toppings:</h2>
            <div class="empty-box-container">
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/truffleTopping.jpg" alt="Summer Truffles">
                        <label>
                            <input type="checkbox" name="toppings[]" value="Summer Truffles">
                            Summer Truffles
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/parsleyTopping.jpg" alt="Parsley Leaves">
                        <label>
                            <input type="checkbox" name="toppings[]" value="Parsley Leaves">
                            Parsley Leaves
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/arugulaTopping.jpg" alt="Arugula Leaves">
                        <label>
                            <input type="checkbox" name="toppings[]" value="Arugula Leaves">
                            Arugula Leaves
                        </label>
                    </div>
                </div>
                <div class="popup-menu-item">
                    <div class="menu-item-placeholder">
                        <img src="images/oreganoTopping.jpg" alt="Oregano Leaves">
                        <label>
                            <input type="checkbox" name="toppings[]" value="Oregano Leaves">
                            Oregano Leaves
                        </label>
                    </div>
                </div>
            </div>

            <hr class="popup-separator">

            <!-- Add to Cart Button -->
            <div class="popup-add-to-cart">
                <button class="create-pizza-submit-btn" onclick="submitCreatePizza()">Add to Cart</button>
            </div>
        </div>
    </div>



    <script src="menu.js"></script> <!-- Use the JavaScript file specific for the menu page -->
</body>
</html>
