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
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the dynamic header -->

    <!-- Home section -->
    <section id="home-section" class="hero">
        <div class="hero-content">
            <h1>Delicious Pizza</h1>
            <a href="menu.php" class="order-btn">Order Now</a>
        </div>
    </section>

    <!-- About Us Section-->
    <section id="about-us-section" class="info-section">
        <div class="section-header">
            <h2>About Us</h2>
        </div>
        <div class="section-content">
            <p>At Delicious Pizza, we believe that a great pizza is more than just a meal; it's an experience. Inspired by the rich traditions of Naples, the birthplace of pizza, our mission is to bring the authentic flavors of Italy to your table, right here in London.</p>
        </div>
    </section>

    <!-- Our philosophy-->
    <section id="philosophy-section" class="info-section">
        <div class="section-header">
            <h2>Our Philosophy</h2>
        </div>
        <div class="section-content">
            <p>We believe in using only the finest ingredients. From San Marzano tomatoes and fresh mozzarella to hand-picked basil and truffles, every element of our pizza is carefully selected to ensure an authentic taste. Our dough is prepared daily, using traditional methods, and baked to perfection in a wood-fired oven, giving it that signature charred crust and soft, airy interior.</p>
        </div>
    </section>
    
    <!-- Sign In/Register Popup Modal -->
    <div id="authModal" class="auth-modal">
        <div class="auth-modal-content">
            <div class="auth-modal-header">
                <span class="close-auth-modal">&times;</span>
                <h2 id="authModalTitle">Authentication</h2>
            </div>
            <div class="auth-modal-body" id="authModalBody">
                <!-- Sign In Form -->
                <div class="auth-section" id="signInSection">
                    <h3>Enter your log-in credentials</h3>
                    <form id="signInForm" action="login.php" method="POST">
                        <input type="text" name="username" placeholder="Username / E-mail address" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" class="auth-btn">Sign in</button>
                    </form>
                </div>

                <!-- Register Form -->
                <div class="auth-section" id="registerSection">
                    <h3>Not Registered? Sign up easily below</h3>
                    <form id="registerForm" action="registration.php" method="POST">
                        <input type="text" name="firstName" placeholder="First Name" required>
                        <input type="text" name="lastName" placeholder="Last Name" required>
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="E-mail address" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" class="auth-btn">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const authModal = document.getElementById('authModal');
            const authModalBody = document.getElementById('authModalBody');
            const authModalTitle = document.getElementById('authModalTitle');
            const closeAuthModal = document.querySelector('.close-auth-modal');

            // Check if there are messages to display
            <?php if (isset($_SESSION['success_message'])): ?>
                authModalTitle.textContent = "Success!";
                authModalBody.innerHTML = `<p style="color: #4CAF50; text-align: center;"><?php echo $_SESSION['success_message']; ?></p>`;
                authModal.style.display = "block";
                <?php unset($_SESSION['success_message']); // Clear the message after displaying it ?>
            <?php elseif (isset($_SESSION['error_message'])): ?>
                authModalTitle.textContent = "Error!";
                authModalBody.innerHTML = `<p style="color: #f44336; text-align: center;"><?php echo $_SESSION['error_message']; ?></p>`;
                authModal.style.display = "block";
                <?php unset($_SESSION['error_message']); // Clear the message after displaying it ?>
            <?php endif; ?>

            // Close the modal when the close button is clicked
            closeAuthModal.onclick = function() {
                authModal.style.display = "none";
                // Optionally, reset the content back to the original form
                location.reload(); // Reload page to reset modal content
            };

            // Close the modal if the user clicks anywhere outside of the modal
            window.onclick = function(event) {
                if (event.target == authModal) {
                    authModal.style.display = "none";
                    location.reload(); // Reload page to reset modal content
                }
            };
        });
    </script>
    <?php include 'footer.php'; ?>

</body>
</html>
