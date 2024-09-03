<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to homepage if not logged in
    exit();
}

include 'db_connection.php'; // Include your DB connection script

$user_id = $_SESSION['user_id'];

// Fetch completed orders for the logged-in user
$query = "SELECT * FROM Orders WHERE user_id = ? AND status IN ('picked up', 'delivered')";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Previous Orders - Delicious Pizza</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?> <!-- Include the regular header -->

    <main>
        <h2>Your Previous Orders</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order">
                    <div class="order-header">
                        <h3>Order #<?php echo $order['id']; ?></h3>
                        <p><?php echo $order['created_at']; ?></p>
                    </div>
                    <div class="order-details">
                        <p><strong>Order Total:</strong> £<?php echo number_format($order['total_price'], 2); ?></p>
                        <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                        <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no previous orders.</p>
        <?php endif; ?>

        <?php $stmt->close(); $conn->close(); ?>
    </main>
    <?php include 'footer.php'; ?>


</body>
</html>
