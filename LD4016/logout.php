<?php
session_start();

// Destroy the session to log out the user
session_destroy();

// Redirect to the homepage or a page where the user sees they are logged out
header("Location: index.php");
exit();
?>
