<?php
session_start();
include 'db_connection.php'; // Include your DB connection script

$response = ['success' => false]; // Initialize response

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        $response['message'] = "User not logged in.";
        echo json_encode($response);
        exit();
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Get form data
    $delivery_address = $_POST['delivery_address'];
    $total_price = 25.99; // Example total price; replace with actual logic to calculate total

    // Prepare and execute the query
    $stmt = $conn->prepare("INSERT INTO Orders (user_id, status, total_price, delivery_address) VALUES (?, 'pending', ?, ?)");
    $stmt->bind_param("ids", $user_id, $total_price, $delivery_address);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Unable to process order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
?>
