<?php
include 'db_connection.php';

if (isset($_GET['ingredient'])) {
    $ingredient = $_GET['ingredient'];
    
    // Modify the query to search for the ingredient in the description or ingredients column
    $query = "SELECT * FROM pizzas WHERE description LIKE ? OR ingredients LIKE ?";
    $stmt = $conn->prepare($query);
    $searchTerm = "%" . $ingredient . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $pizzas = [];
    while ($row = $result->fetch_assoc()) {
        $pizzas[] = [
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'image' => $row['image_url'] // Ensure your image field matches your database schema
        ];
    }
    
    // Return the filtered pizzas as JSON
    echo json_encode($pizzas);
} else {
    echo json_encode([]);
}
?>
