<?php

session_start();
require_once "../db_connection.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $order_id = $_POST["order_id"];
    $status = $_POST["status"];

    $sql = "UPDATE orders
            SET status = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    $stmt->execute();

    $stmt->close();
}

header("Location: orders.php");
exit();

?>