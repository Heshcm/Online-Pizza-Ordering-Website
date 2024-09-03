<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connection.php'; // DB Connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Check for admin credentials
    if ($usernameOrEmail === 'admin' && $password === 'admin') {
        // Set session variables for admin
        $_SESSION['user_id'] = 'admin';
        $_SESSION['username'] = 'admin';
        $_SESSION['role'] = 'admin';
        
        header("Location: new_orders.php"); // Redirect to the admin dashboard
        exit();
    }

    // Regular user authentication
    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM Users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $email, $hashedPassword, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            $_SESSION['success_message'] = "Welcome, $username!";
            header("Location: index.php"); // Redirect to a dashboard or homepage
        } else {
            $_SESSION['error_message'] = "Invalid password. Please try again.";
            header("Location: index.php");
        }
    } else {
        $_SESSION['error_message'] = "No account found with that email or username.";
        header("Location: index.php");
    }

    $stmt->close();
    $conn->close();
}
?>