<?php

session_start();
require_once "db_connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["food_id"])) {

    $user_id = $_SESSION["user_id"];
    $food_id = $_GET["food_id"];

    // Check whether this food is already in the user's cart
    $sql = "SELECT * FROM cart WHERE user_id = ? AND food_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $food_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        // Increase quantity
        $sql = "UPDATE cart
                SET quantity = quantity + 1
                WHERE user_id = ? AND food_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $food_id);
        $stmt->execute();

    } else {

        // Add new food to cart
        $sql = "INSERT INTO cart (user_id, food_id, quantity)
                VALUES (?, ?, 1)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $food_id);
        $stmt->execute();
    }

    $stmt->close();
}

header("Location: cart.php");
exit();

?>