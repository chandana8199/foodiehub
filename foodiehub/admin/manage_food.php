<?php
session_start();

// Include the database connection file
require_once '../db/db.php'; // Make sure the path is correct

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Sample admin username
$admin_username = "Admin"; // Replace this with the actual username or fetch from DB

// Fetch food items from the database
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food Items - FoodieHub</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff8f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ff6f61;
            color: white;
            padding: 30px 0;
            text-align: center;
            position: relative;
        }

        header img.logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        header span {
            color: #ffe082;
        }

        header .admin-icon {
            position: absolute;
            top: 30px;
            right: 20px;
            font-size: 24px;
            color: white;
            text-decoration: none;
        }

        header .admin-icon:hover {
            color: white;
        }

        .dashboard {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            margin: 20px auto;
            width: 80%;
            max-width: 1000px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard h2 {
            color: #ff6f61;
        }

        .dashboard p {
            font-size: 18px;
            color: #555;
        }

        .dashboard .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .dashboard .btn:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #fbe9e7;
            padding: 15px;
            text-align: center;
            color: #555;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #ff6f61;
            color: white;
        }

        .order-status {
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-preparing {
            background-color: #ffb74d;
            color: white;
        }

        .status-out-for-delivery {
            background-color: #4caf50;
            color: white;
        }

        .status-delivered {
            background-color: #2196f3;
            color: white;
        }

    </style>
</head>
<body>

    <header>
        <div class="container">
            <img src="../assets/logo.png" alt="FoodieHub Logo" class="logo">
            <h1>🍔 Admin Dashboard - FoodieHub</h1>
        </div>
        <a href="login.php" class="admin-icon">👑 Admin</a>
    </header>

    <div class="dashboard">
        <h2>Manage Food Items</h2>
        <p>Here you can add, edit, or delete food items available in the system.</p>

        <div>
            <a href="add_food.php" class="btn">Add New Food Item</a>
        </div>

        <div class="food-items">
            <h3>Food Items List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Food ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['name'] . "</td>
                                    <td>" . $row['description'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>
                                        <a href='edit_food.php?id=" . $row['id'] . "' class='btn'>Edit</a>
                                        <a href='delete_food.php?id=" . $row['id'] . "' class='btn' style='background-color: #f44336;'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No food items available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <footer>
        <p>&copy; 2025 FoodieHub  | All Rights Reserved</p>
    </footer>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
