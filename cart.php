<?php

session_start();
require_once "db_connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT cart.id,
               food_items.name,
               food_items.price,
               cart.quantity,
               (food_items.price * cart.quantity) AS subtotal
        FROM cart
        INNER JOIN food_items
        ON cart.food_id = food_items.id
        WHERE cart.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$total = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Cart</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<h1>My Cart 🛒</h1>

<?php if ($result->num_rows > 0): ?>

    <table>

        <tr>
            <th>Food</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($item = $result->fetch_assoc()): ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($item["name"]); ?>
                </td>

                <td>
                    ₹<?php echo $item["price"]; ?>
                </td>

                <td>
                    <?php echo $item["quantity"]; ?>
                </td>

                <td>
                    ₹<?php echo $item["subtotal"]; ?>
                </td>

            </tr>

            <?php
            $total += $item["subtotal"];
            ?>

        <?php endwhile; ?>

    </table>

    <h2>Total: ₹<?php echo $total; ?></h2>

    <a href="checkout.php">
        <button>Proceed to Checkout</button>
    </a>

<?php else: ?>

    <p>Your cart is empty.</p>

<?php endif; ?>

<br><br>

<a href="menu.php">
    Continue Shopping
</a>

<br><br>

<a href="index.php">
    Back to Home
</a>

</body>

</html>