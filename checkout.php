<?php

session_start();
require_once "db_connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT cart.food_id, cart.quantity, food_items.price 
        FROM cart 
        INNER JOIN food_items 
        ON cart.food_id = food_items.id 
        WHERE cart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$total = 0;
$cart_items = [];

while ($item = $result->fetch_assoc()) {

    $cart_items[] = $item;

    $total += $item["price"] * $item["quantity"];
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .checkout-container {
            max-width: 700px;
            margin: 30px auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .order-item {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            text-align: right;
            color: #d35400;
        }

        .place-order {
            text-align: center;
            margin-top: 25px;
        }

    </style>

</head>

<body>

    <h1>Checkout 💳</h1>

    <div class="checkout-container">

        <?php if (count($cart_items) > 0): ?>

            <h2>Order Summary</h2>

            <?php foreach ($cart_items as $item): ?>

                <div class="order-item">

                    <strong>
                        Food ID:
                        <?php echo $item["food_id"]; ?>
                    </strong>

                    <br><br>

                    Quantity:
                    <?php echo $item["quantity"]; ?>

                    <br>

                    Price:
                    ₹<?php echo $item["price"]; ?>

                </div>

            <?php endforeach; ?>

            <h2 class="total">
                Total Amount: ₹<?php echo $total; ?>
            </h2>

            <div class="place-order">

                <form action="place_order.php" method="POST">

                    <input
                        type="hidden"
                        name="total_amount"
                        value="<?php echo $total; ?>"
                    >

                    <button type="submit">
                        Place Order 🎉
                    </button>

                </form>

            </div>

        <?php else: ?>

            <p>Your cart is empty.</p>

            <a href="menu.php">
                Go to Menu
            </a>

        <?php endif; ?>

    </div>

    <center>

        <a href="cart.php">
            Back to Cart
        </a>

        <br><br>

        <a href="index.php">
            Back to Home
        </a>

    </center>

</body>

</html>