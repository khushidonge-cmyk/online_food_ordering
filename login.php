<?php

session_start();
require_once "db_connection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            $stmt->close();

            header("Location: index.php");
            exit();

        } else {

            $message = "Invalid password.";

        }

    } else {

        $message = "User not found.";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1>Login 🔐</h1>

    <?php if ($message != ""): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>Email:</label>
        <br>

        <input type="email" name="email" required>

        <br><br>

        <label>Password:</label>
        <br>

        <input type="password" name="password" required>

        <br><br>

        <button type="submit">
            Login
        </button>

    </form>

    <br>

    <a href="register.php">
        Create Account
    </a>

    <br><br>

    <a href="index.php">
        Back to Home
    </a>

</body>

</html>