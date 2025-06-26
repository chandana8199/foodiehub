<?php
// place_order.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db/db.php');

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!$data) {
    echo json_encode(["success" => false, "error" => "Invalid JSON"]);
    exit;
}

// Extract and sanitize data
$items = $data['items'];
$total_price = floatval($data['total_price']);
$delivery_fee = floatval($data['delivery_fee']);
$gst = floatval($data['gst']);
$final_amount = floatval($data['final_amount']);
$status = isset($data['status']) ? $conn->real_escape_string($data['status']) : null;

// Validate items
if (empty($items)) {
    echo json_encode(["success" => false, "error" => "'items' cannot be empty"]);
    exit;
}

$items = $conn->real_escape_string($items);

// Prepare and execute SQL
if ($status) {
    $sql = "INSERT INTO `orders` (items, total_price, delivery_fee, gst, final_amount, status) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdddds", $items, $total_price, $delivery_fee, $gst, $final_amount, $status);
} else {
    $sql = "INSERT INTO `orders` (items, total_price, delivery_fee, gst, final_amount) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdddd", $items, $total_price, $delivery_fee, $gst, $final_amount);
}

if ($stmt === false) {
    echo json_encode(["success" => false, "error" => "Failed to prepare statement"]);
    exit;
}

if ($stmt->execute()) {
    echo json_encode(["success" => true, "order_id" => $stmt->insert_id]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
?>
