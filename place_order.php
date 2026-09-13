<?php

session_start();
require_once "db_connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$total_amount = $_POST["total_amount"];

// 1. Create order
$sql = "INSERT INTO orders (user_id, total_amount, status)
        VALUES (?, ?, 'Pending')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total_amount);
$stmt->execute();

$order_id = $stmt->insert_id;

$stmt->close();

// 2. Get user's cart items
$sql = "SELECT food_id, quantity, price
        FROM cart
        INNER JOIN food_items
        ON cart.food_id = food_items.id
        WHERE cart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

// 3. Save each cart item in order_items
while ($item = $result->fetch_assoc()) {

    $sql = "INSERT INTO order_items
            (order_id, food_id, quantity, price)
            VALUES (?, ?, ?, ?)";

    $item_stmt = $conn->prepare($sql);

    $item_stmt->bind_param(
        "iiid",
        $order_id,
        $item["food_id"],
        $item["quantity"],
        $item["price"]
    );

    $item_stmt->execute();

    $item_stmt->close();
}

$stmt->close();

// 4. Empty the cart
$sql = "DELETE FROM cart WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Placed</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .success-container {
            max-width: 600px;
            margin: 60px auto;
            padding: 35px;
            background-color: white;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .success-container h1 {
            color: #27ae60;
        }

        .order-info {
            margin: 20px 0;
            font-size: 18px;
        }

    </style>

</head>

<body>

    <div class="success-container">

        <h1>Order Placed Successfully! 🎉</h1>

        <div class="order-info">

            <p>
                Your Order ID is:
                <strong><?php echo $order_id; ?></strong>
            </p>

            <p>
                Total Amount:
                <strong>₹<?php echo $total_amount; ?></strong>
            </p>

            <p>
                Status:
                <strong>Pending</strong>
            </p>

        </div>

        <br>

        <a href="orders.php">
            <button>View My Orders 📦</button>
        </a>

        <br><br>

        <a href="menu.php">
            Continue Shopping
        </a>

        <br><br>

        <a href="index.php">
            Go to Home
        </a>

    </div>

</body>

</html>