<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "delecious__pizza"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all items from a given table
function getAllItems($conn, $tableName) {
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch items from the database
$pizzas = getAllItems($conn, 'Pizzas');
$desserts = getAllItems($conn, 'Desserts');
$beverages = getAllItems($conn, 'Beverages');
?>
