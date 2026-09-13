<?php

session_start();
require_once "../db_connection.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT orders.id,
               orders.user_id,
               users.name,
               users.email,
               orders.total_amount,
               orders.status,
               orders.order_date
        FROM orders
        INNER JOIN users
        ON orders.user_id = users.id
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Orders</title>

    <link rel="stylesheet" href="admin_style.css">

    <style>

        .orders-container {
            max-width: 1100px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        .orders-container h2 {
            text-align: center;
            color: #d35400;
            margin-bottom: 20px;
        }

        .status-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .status-form select {
            padding: 8px;
        }

        .status-form button {
            padding: 8px 12px;
        }

        .bottom-links {
            text-align: center;
            margin: 25px;
        }

    </style>

</head>

<body>

    <h1>Manage Orders 📦</h1>

    <div class="orders-container">

        <h2>Customer Orders</h2>

        <?php if ($result->num_rows > 0): ?>

        <table>

            <tr>

                <th>Order ID</th>
                <th>User ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Update Status</th>

            </tr>

            <?php while ($order = $result->fetch_assoc()): ?>

            <tr>

                <td>
                    <?php echo $order["id"]; ?>
                </td>

                <td>
                    <?php echo $order["user_id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($order["name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($order["email"]); ?>
                </td>

                <td>
                    ₹<?php echo $order["total_amount"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($order["status"]); ?>
                </td>

                <td>
                    <?php echo $order["order_date"]; ?>
                </td>

                <td>

                    <form
                        action="update_order_status.php"
                        method="POST"
                        class="status-form"
                    >

                        <input
                            type="hidden"
                            name="order_id"
                            value="<?php echo $order["id"]; ?>"
                        >

                        <select name="status">

                            <option
                                value="Pending"
                                <?php
                                if ($order["status"] == "Pending")
                                    echo "selected";
                                ?>
                            >
                                Pending
                            </option>

                            <option
                                value="Confirmed"
                                <?php
                                if ($order["status"] == "Confirmed")
                                    echo "selected";
                                ?>
                            >
                                Confirmed
                            </option>

                            <option
                                value="Preparing"
                                <?php
                                if ($order["status"] == "Preparing")
                                    echo "selected";
                                ?>
                            >
                                Preparing
                            </option>

                            <option
                                value="Delivered"
                                <?php
                                if ($order["status"] == "Delivered")
                                    echo "selected";
                                ?>
                            >
                                Delivered
                            </option>

                        </select>

                        <button type="submit">
                            Update
                        </button>

                    </form>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

        <?php else: ?>

            <p style="text-align:center;">
                No orders found.
            </p>

        <?php endif; ?>

    </div>

    <div class="bottom-links">

        <a href="admin_dashboard.php">
            Back to Dashboard
        </a>

        <br><br>

        <a href="admin_logout.php">
            Logout
        </a>

    </div>

</body>

</html>