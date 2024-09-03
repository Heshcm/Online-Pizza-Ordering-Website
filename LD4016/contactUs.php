<?php
session_start(); // Start the session to access session variables
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Delicious Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the dynamic header -->


    <main>
        <section class="faq-section">
            <h1>Frequently Asked Questions</h1>
            
            <div class="faq-item">
                <h2>What are your opening hours?</h2>
                <p>We are open Monday to Friday from 11:00 AM to 10:00 PM, and Saturday and Sunday from 12:00 PM to 11:00 PM. We also offer delivery during these hours, so you can enjoy our delicious pizza wherever you are!</p>
            </div>

            <div class="faq-item">
                <h2>Do you offer gluten-free or vegan options?</h2>
                <p>Yes, we do! We offer a range of gluten-free pizzas and vegan options. Our gluten-free pizzas are made with a special crust, and our vegan pizzas feature dairy-free cheese and a variety of fresh, plant-based toppings. Please inform us of any allergies or dietary requirements when placing your order.</p>
            </div>
        </section>

        <section class="contact-form-section">
            <h1>Reach out to us</h1>
            <form>
                <div class="form-group">
                    <div class="form-field">
                        <label for="first-name">First name</label>
                        <input type="text" id="first-name" name="first-name">
                    </div>
                    <div class="form-field">
                        <label for="last-name">Last name</label>
                        <input type="text" id="last-name" name="last-name">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail address</label>
                    <input type="email" id="email" name="email">
                </div>
                
                <div class="form-group">
                    <label for="message">Your message</label>
                    <textarea id="message" name="message" rows="5"></textarea>
                </div>
                

                <button type="submit" class="submit-btn">Send message</button>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>

</body>
</html>
