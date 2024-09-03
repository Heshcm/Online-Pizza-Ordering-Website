<?php
session_start();

// Check if the user is an admin, otherwise redirect to the home page
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Delicious Pizza</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo"></div>
        <nav>
            <ul>
                <li><a href="new_orders.php">New Orders</a></li>
                <li><a href="current_orders.php">Current Orders</a></li>
                <li><a href="previous_orders.php">Previous orders</a></li>
                <li class="my-account">
                    <a href="#">My account</a>
                    <div class="account-dropdown">
                        <a href="#" class="logout-btn" style="background-color: red; color: white;">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.querySelector('.logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to log out?')) {
                        window.location.href = 'logout.php';
                    }
                });
            }
        });
    </script>
</body>
</html>
