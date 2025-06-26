<?php
session_start();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dummy login check (you can replace this with real DB validation)
    if ($username == 'admin' && $password == 'password') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php"); // Redirect to the admin dashboard
        exit();
    } else {
        $error_message = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FoodieHub</title>
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

        main {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            margin: 20px auto;
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #fbe9e7;
            padding: 15px;
            text-align: center;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <img src="../assets/logo.png" alt="FoodieHub Logo" class="logo">
            <h1>🍔 Admin Login - FoodieHub</h1>
        </div>
        <!-- Admin Icon Link placed in the header -->
        <a href="../admin/login.php" class="admin-icon">👑 Admin</a>
    </header>

    <main>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
    </main>

    <footer>
        <p>&copy; 2025 FoodieHub  | All Rights Reserved</p>
    </footer>

</body>
</html>
