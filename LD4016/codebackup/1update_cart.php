<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $itemName = $_POST['item'];
        $quantity = intval($_POST['quantity']);
        $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

        if ($action === 'add' && !empty($itemName) && $quantity > 0 && $price > 0) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$itemName])) {
                $_SESSION['cart'][$itemName]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$itemName] = [
                    'quantity' => $quantity,
                    'price' => $price,
                ];
            }

            echo json_encode(['status' => 'success', 'message' => 'Item added to cart']);
        } elseif ($action === 'add_custom' && !empty($itemName) && $quantity > 0) {
            $details = json_decode($_POST['details'], true);
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $customPizzaId = uniqid('custom_pizza_');
            $_SESSION['cart'][$customPizzaId] = [
                'quantity' => $quantity,
                'price' => 11.95, // Adjust the price accordingly
                'details' => $details,
            ];

            echo json_encode(['status' => 'success', 'message' => 'Custom pizza added to cart']);
        } elseif ($action === 'update' && !empty($itemName) && $quantity >= 0) {
            if ($quantity == 0) {
                unset($_SESSION['cart'][$itemName]);
            } else {
                $_SESSION['cart'][$itemName]['quantity'] = $quantity;
            }

            echo json_encode(['status' => 'success', 'message' => 'Cart updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data provided']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No action specified']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
