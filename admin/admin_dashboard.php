<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="admin_style.css">

    <style>

        .dashboard-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .admin-menu {
            margin-top: 25px;
        }

        .admin-menu a {
            display: block;
            padding: 12px;
            margin: 10px 0;
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        .admin-menu a:hover {
            background-color: #eeeeee;
            text-decoration: none;
        }

    </style>

</head>

<body>

    <div class="dashboard-container">

        <h1>Admin Dashboard 👨‍💼</h1>

        <h2>
            Welcome,
            <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>!
        </h2>

        <hr>

        <h3>Admin Menu</h3>

        <div class="admin-menu">

            <a href="add_food.php">
                🍕 Add Food
            </a>

            <a href="manage_food.php">
                🍔 Manage Food
            </a>

            <a href="orders.php">
                📦 View Orders
            </a>

            <a href="admin_logout.php">
                🚪 Logout
            </a>

        </div>

    </div>

</body>

</html>