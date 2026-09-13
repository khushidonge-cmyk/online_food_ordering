<?php

session_start();
require_once "../db_connection.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM food_items WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

header("Location: manage_food.php");
exit();

?>