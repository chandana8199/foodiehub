<?php
require_once '../db/db.php'; // Your DB connection

$sql = "SELECT id, status FROM orders";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'id' => $row['id'],
            'status' => $row['status']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($orders);
?>
