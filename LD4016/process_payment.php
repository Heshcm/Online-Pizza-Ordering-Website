<?php
session_start();

// Assuming payment is processed here...
// Check if the payment was successful
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_type'])) {
    $orderType = $_POST['order_type']; // Retrieve user's choice

    // Redirect based on the user's choice
    if ($orderType === 'pickup') {
        header('Location: confirmation_pickup.php');
    } elseif ($orderType === 'delivery') {
        header('Location: confirmation_delivery.php');
    } else {
        // Default case or handle error
        header('Location: checkout.php');
    }
    exit();
} else {
    // Handle invalid access or error
    header('Location: checkout.php');
    exit();
}
?>
