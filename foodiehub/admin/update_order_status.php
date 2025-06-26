<?php
// Include the database connection file
require_once '../db/db.php'; // Make sure the path is correct

// Check if the necessary data is received via POST
if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Sanitize input to prevent SQL injection
    $order_id = intval($order_id);
    $status = mysqli_real_escape_string($conn, $status);

    // Prepare SQL query to update the order status
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Bind the parameters
    $stmt->bind_param("si", $status, $order_id);

    // Execute the query and check if the update is successful
    if ($stmt->execute()) {
        // Return the updated status as the response
        echo $status;
    } else {
        // In case of error, return an error message
        echo "Error updating status";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // If no order_id or status is provided, return an error message
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
