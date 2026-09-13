<?php

require_once "db_connection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sss",
        $name,
        $email,
        $hashed_password
    );

    if ($stmt->execute()) {

        $message = "Registration successful!";

    } else {

        $message = "Registration failed: " . $conn->error;

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <h1>Create Account 👤</h1>

    <?php if ($message != ""): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>Name:</label>
        <br>

        <input
            type="text"
            name="name"
            required
        >

        <br><br>

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
            Register
        </button>

    </form>

    <br>

    <a href="login.php">
        Already have an account? Login
    </a>

    <br><br>

    <a href="index.php">
        Back to Home
    </a>

</body>

</html>