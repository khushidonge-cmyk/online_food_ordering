<?php

session_start();
require_once "../db_connection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admins WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $admin = $result->fetch_assoc();

        if ($password == $admin["password"]) {

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_name"] = $admin["name"];

            $stmt->close();

            header("Location: admin_dashboard.php");
            exit();

        } else {

            $message = "Invalid password.";

        }

    } else {

        $message = "Admin not found.";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <link rel="stylesheet" href="admin_style.css">

</head>

<body>

    <h1>Admin Login 🔐</h1>

    <?php if ($message != ""): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>Email:</label>
        <br>

        <input
            type="email"
            name="email"
            required
        >

        <br><br>

        <label>Password:</label>
        <br>

        <input
            type="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">
            Admin Login
        </button>

    </form>

    <br>

    <a href="../index.php">
        Back to Website
    </a>

</body>

</html>