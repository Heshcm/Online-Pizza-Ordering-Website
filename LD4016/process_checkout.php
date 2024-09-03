<?php
session_start();
include 'db_connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderType = $_POST['orderType'];
    $userId = $_SESSION['user_id'] ?? null;
    $totalPrice = $_SESSION['cart_total'] ?? 0; // Assuming you store the cart total in a session variable
    $createdAt = date('Y-m-d H:i:s');
    $status = 'new'; // Initial status of the order

    // If delivery, get address details
    $deliveryAddress = '';
    if ($orderType === 'delivery') {
        $streetAddress = $_POST['streetAddress'];
        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        $deliveryAddress = "$streetAddress, $city, $postcode";
    }

    // Prepare and execute the order insertion query
    $stmt = $conn->prepare("INSERT INTO orders (user_id, status, total_price, delivery_address, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $userId, $status, $totalPrice, $deliveryAddress, $createdAt);

    if ($stmt->execute()) {
        // Order inserted successfully, redirect to the confirmation page
        if ($orderType === 'delivery') {
            header("Location: confirmation_delivery.php");
        } else {
            header("Location: confirmation_pickup.php");
        }
        exit();
    } else {
        // Handle insertion error
        echo "Unable to process checkout: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
