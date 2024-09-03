<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: index.php"); // Redirect to homepage if not admin
    exit();
}

include 'db_connection.php'; // Include your DB connection script

// Fetch orders from the database where the status is 'picked up' or 'delivered'
$query = "SELECT * FROM Orders WHERE status IN ('picked up', 'delivered')";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Orders - Delicious Pizza Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> <!-- Admin-specific header -->

    <main>
        <h2>Previous Orders</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order">
                    <div class="order-header">
                        <h3>Order #<?php echo $order['id']; ?></h3>
                        <p><?php echo $order['created_at']; ?></p>
                    </div>
                    <div class="order-details">
                        <p><strong>Order Total:</strong> £<?php echo number_format($order['total_price'], 2); ?></p>
                        <p><strong>Delivery Address:</strong> <?php echo $order['delivery_address']; ?></p>
                        <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No previous orders at the moment.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </main>

</body>
</html>
