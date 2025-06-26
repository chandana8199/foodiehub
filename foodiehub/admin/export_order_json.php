<?php
// Include the database connection file
require_once '../db/db.php'; // Ensure the path to db.php is correct

// Check if the order_id is provided in the query string
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Prepare SQL query to fetch order details by order_id
    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the order exists
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // Prepare the data to be exported as JSON
        $order_data = array(
            'order_id' => $order['id'],
            'items' => $order['items'],
            'amount' => $order['final_amount'],
            'status' => $order['status'],
            'timestamp' => $order['timestamp'], // Assuming you have a timestamp field
        );

        // Set the header for the response to indicate JSON download
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="order_' . $order_id . '.json"');

        // Output the order data as JSON
        echo json_encode($order_data, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array("error" => "Order not found."));
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(array("error" => "No order ID specified."));
}

// Close the database connection
$conn->close();
?>
