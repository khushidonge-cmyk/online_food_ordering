<?php

session_start();
require_once "db_connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM orders
        WHERE user_id = ?
        ORDER BY order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Orders</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .orders-container {
            max-width: 900px;
            margin: 30px auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .status {
            font-weight: bold;
        }

    </style>

</head>

<body>

    <h1>My Orders 📦</h1>

    <div class="orders-container">

        <?php if ($result->num_rows > 0): ?>

            <table>

                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>

                <?php while ($order = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $order["id"]; ?>
                        </td>

                        <td>
                            ₹<?php echo $order["total_amount"]; ?>
                        </td>

                        <td class="status">
                            <?php echo htmlspecialchars($order["status"]); ?>
                        </td>

                        <td>
                            <?php echo $order["order_date"]; ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </table>

        <?php else: ?>

            <p>You have not placed any orders yet.</p>

        <?php endif; ?>

    </div>

    <center>

        <a href="menu.php">
            Continue Shopping
        </a>

        <br><br>

        <a href="index.php">
            Back to Home
        </a>

    </center>

</body>

</html>