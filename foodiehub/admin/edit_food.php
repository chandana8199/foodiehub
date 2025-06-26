<?php
session_start();
require_once '../db/db.php'; // Ensure correct path to db connection

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if food item ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the food item details
    $sql = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $food_item = $result->fetch_assoc();
}

// Handle form submission for editing the food item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Update the food item
    $update_sql = "UPDATE menu SET name = ?, description = ?, price = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssdi", $name, $description, $price, $id);
    $update_stmt->execute();
    
    // Redirect to manage food page
    header("Location: manage_food.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Item - FoodieHub</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Centering the form */
        .dashboard {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 80vh;
            text-align: center;
        }

        form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Edit Food Item</h1>
        </div>
    </header>
    
    <div class="dashboard">
        <h2>Edit Food Item: <?php echo htmlspecialchars($food_item['name']); ?></h2>
        <form method="POST">
            <label for="name">Food Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($food_item['name']); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($food_item['description']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo htmlspecialchars($food_item['price']); ?>" required>

            <button type="submit" class="btn">Update Food Item</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 FoodieHub | All Rights Reserved</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
