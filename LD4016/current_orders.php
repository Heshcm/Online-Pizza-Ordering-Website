<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 'admin') {
    header("Location: index.php"); // Redirect to homepage if not admin
    exit();
}

include 'db_connection.php'; // Include your DB connection script

// Fetch current orders from the database where the status is 'processing', 'preparing', 'ready for pickup', or 'on its way'
$query = "SELECT * FROM Orders WHERE status IN ('processing', 'preparing', 'ready for pickup', 'on its way')";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Orders - Delicious Pizza Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'admin_header.php'; ?> <!-- Admin-specific header -->

    <main>
        <h2>Current Orders</h2>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order" id="order-<?php echo $order['id']; ?>">
                    <div class="order-header">
                        <h3>Order #<?php echo $order['id']; ?></h3>
                        <p><?php echo $order['created_at']; ?></p>
                    </div>
                    <div class="order-details">
                        <p><strong>Order Total:</strong> £<?php echo number_format($order['total_price'], 2); ?></p>
                        <p><strong>Delivery Address:</strong> <?php echo $order['delivery_address']; ?></p>
                    </div>
                    <!-- Button based on order status -->
                    <?php if ($order['status'] === 'processing'): ?>
                        <button class="status-btn" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'preparing', '<?php echo $order['delivery_address']; ?>')">Preparing</button>
                    <?php elseif ($order['status'] === 'preparing' && $order['delivery_address'] === 'Pickup'): ?>
                        <button class="status-btn" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'ready for pickup', 'Pickup')">Ready for Pickup</button>
                    <?php elseif ($order['status'] === 'preparing' && $order['delivery_address'] !== 'Pickup'): ?>
                        <button class="status-btn" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'on its way', 'Delivery')">On Its Way</button>
                    <?php elseif ($order['status'] === 'ready for pickup'): ?>
                        <button class="status-btn" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'picked up', 'Pickup')">Picked Up</button>
                    <?php elseif ($order['status'] === 'on its way'): ?>
                        <button class="status-btn" onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'delivered', 'Delivery')">Delivered</button>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No current orders at the moment.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </main>

<script>
    // Function to update the order status dynamically
    function updateOrderStatus(orderId, nextStatus, orderType) {
        // AJAX request to update the order status in the database
        fetch('update_order_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `order_id=${orderId}&status=${nextStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the button text or remove the order
                const orderElement = document.getElementById(`order-${orderId}`);
                if (nextStatus === 'preparing') {
                    const newStatus = orderType === 'Pickup' ? 'ready for pickup' : 'on its way';
                    orderElement.querySelector('.status-btn').textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    orderElement.querySelector('.status-btn').setAttribute('onclick', `updateOrderStatus(${orderId}, '${newStatus}', '${orderType}')`);
                } else if (nextStatus === 'ready for pickup' || nextStatus === 'on its way') {
                    const finalStatus = nextStatus === 'ready for pickup' ? 'picked up' : 'delivered';
                    orderElement.querySelector('.status-btn').textContent = finalStatus.charAt(0).toUpperCase() + finalStatus.slice(1);
                    orderElement.querySelector('.status-btn').setAttribute('onclick', `updateOrderStatus(${orderId}, '${finalStatus}', '${orderType}')`);
                } else {
                    // Remove from current orders and move to previous orders page
                    orderElement.remove();
                    // Optionally, you could also use AJAX to append it to the 'previous orders' page if dynamic loading is desired
                }
            } else {
                alert(data.message || 'Error updating order status.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>
