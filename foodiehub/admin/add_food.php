<?php
session_start();

// Include the database connection file
require_once '../db/db.php'; // Ensure the path is correct

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle form submission for adding a new food item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form input values
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Insert new food item into the database
    $sql = "INSERT INTO menu (name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $name, $description, $price);

    if ($stmt->execute()) {
        // Redirect to manage food items page
        header("Location: manage_food.php");
        exit();
    } else {
        echo "Error adding food item: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Item - FoodieHub</title>
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
            <h1>Add New Food Item</h1>
        </div>
    </header>

    <div class="dashboard">
        <h2>Add New Food Item</h2>
        <form method="POST">
            <label for="name">Food Name:</label>
            <input type="text" name="name" required>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" name="price" required>

            <button type="submit" class="btn">Add Food Item</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 FoodieHub | All Rights Reserved</p>
    </footer>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
