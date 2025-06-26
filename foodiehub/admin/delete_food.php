<?php
session_start();

// Include the database connection file
require_once '../db/db.php'; // Ensure the path is correct

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if food item ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the food item from the database
    $sql = "DELETE FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to manage food items page
        header("Location: manage_food.php");
        exit();
    } else {
        echo "Error deleting food item: " . $conn->error;
    }
} else {
    echo "Food item ID is required!";
}

// Close database connection
$conn->close();
?>
