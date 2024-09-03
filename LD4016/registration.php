<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connection.php'; // Include your DB connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: index.php");
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM Users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "Email or Username already exists.";
        header("Location: index.php");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password, role) VALUES (?, ?, ?, 'customer')");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Registration successful! Please log in.";
        header("Location: index.php");
    } else {
        $_SESSION['error_message'] = "Something went wrong. Please try again.";
        header("Location: index.php");
    }

    $stmt->close();
    $conn->close();
}
?>
