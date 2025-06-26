<?php
session_start();

// Include the database connection file
require_once '../db/db.php'; // Make sure the path is correct

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Sample admin dashboard content
$admin_username = "Admin";  // Replace this with the actual username or fetched from DB if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodieHub</title>
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

        .btn-group {
            display: flex;
            justify-content: space-between;
            width: 100%;
            gap: 5px;
        }

        .btn-group .btn {
            padding: 6px 12px;
            font-size: 12px;
            width: 30%;
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
        <h2>Welcome, <?php echo $admin_username; ?>!</h2>
        <p>You're logged in as the admin. From here, you can manage the system's content and view orders.</p>

        <div>
            <a href="manage_food.php" class="btn">Manage Food Items</a>
            <a href="view_orders.php" class="btn">View Orders</a>
            <a href="logout.php" class="btn">Logout</a>
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
