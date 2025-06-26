<?php
session_start();

// Include the database connection file
require_once '../db/db.php'; // Make sure the path is correct

// Check if the admin is logged in, if not redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch the filter status if any
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Prepare SQL query to fetch orders based on status filter
$sql = "SELECT * FROM orders";
if ($status_filter) {
    $sql .= " WHERE status = ?";
}
$stmt = $conn->prepare($sql);
if ($status_filter) {
    $stmt->bind_param("s", $status_filter);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - FoodieHub</title>
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

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .btn:hover {
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
            font-weight: bold;
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

        .export-container {
            margin-top: 12px;
            display: flex;
            justify-content: center;
        }

        .export-btn {
            padding: 6px 14px;
            font-size: 13px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .export-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // When a status button is clicked
            $('.update-status').on('click', function() {
                var orderId = $(this).data('order-id');
                var status = $(this).data('status');
                
                // Send an AJAX request to update the status
                $.ajax({
                    url: 'update_order_status.php',
                    type: 'POST',
                    data: { order_id: orderId, status: status },
                    success: function(response) {
                        // Update the status on the page without refreshing
                        $('#status_' + orderId).text(response);
                    },
                    error: function() {
                        alert('Error updating status.');
                    }
                });
            });

            // ✅ AJAX polling to fetch live order statuses every 10 seconds
            setInterval(function() {
                $.ajax({
                    url: 'fetch_order_statuses.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        data.forEach(function(order) {
                            const statusCell = $('#status_' + order.id);
                            if (statusCell.length && statusCell.text().trim() !== order.status) {
                                statusCell.text(order.status);
                            }
                        });
                    },
                    error: function() {
                        console.error('Failed to fetch live order statuses.');
                    }
                });
            }, 10000);
        });
    </script>
</head>
<body>

    <header>
        <div class="container">
            <img src="../assets/logo.png" alt="FoodieHub Logo" class="logo">
            <h1>🍔 View Orders - FoodieHub</h1>
        </div>
        <a href="login.php" class="admin-icon">👑 Admin</a>
    </header>

    <div class="dashboard">
        <h2>All Orders</h2>
        <p>From here, you can view and update the orders.</p>

        <div>
            <a href="manage_food.php" class="btn">Manage Food Items</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>

        <div class="filter">
            <form method="get" action="view_orders.php">
                <label for="status">Filter by Status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="Preparing" <?php echo ($status_filter == 'Preparing') ? 'selected' : ''; ?>>Preparing</option>
                    <option value="Out for Delivery" <?php echo ($status_filter == 'Out for Delivery') ? 'selected' : ''; ?>>Out for Delivery</option>
                    <option value="Delivered" <?php echo ($status_filter == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                </select>
                <button type="submit" class="btn">Filter</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Update / Export</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['items'] . "</td>
                                <td>" . $row['final_amount'] . "</td>
                                <td id='status_" . $row['id'] . "' class='order-status'>" . $row['status'] . "</td>
                                <td>
                                    <div class='btn-group'>
                                        <button data-order-id='" . $row['id'] . "' data-status='Preparing' class='btn update-status'>Preparing</button>
                                        <button data-order-id='" . $row['id'] . "' data-status='Out for Delivery' class='btn update-status'>Out for Delivery</button>
                                        <button data-order-id='" . $row['id'] . "' data-status='Delivered' class='btn update-status'>Delivered</button>
                                    </div>
                                    <div class='export-container'>
                                        <a href='export_order_json.php?order_id=" . $row['id'] . "' class='btn export-btn'>Download Order Summary</a>
                                    </div>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

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
