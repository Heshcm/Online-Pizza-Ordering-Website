<?php
session_start();

// Clear the cart session
unset($_SESSION['cart']);

// Optionally, you could also destroy the entire session
// session_destroy();

echo json_encode(['success' => true, 'message' => 'Cart emptied']);
?>
