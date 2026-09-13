<?php

session_start();
require_once "../db_connection.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_POST["image"];
    $category = $_POST["category"];

    $sql = "INSERT INTO food_items
            (name, description, price, image, category)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssdss",
        $name,
        $description,
        $price,
        $image,
        $category
    );

    if ($stmt->execute()) {
        $message = "Food added successfully!";
    } else {
        $message = "Failed to add food.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Food</title>

    <link rel="stylesheet" href="admin_style.css">

    <style>

        .form-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            box-sizing: border-box;
        }

        .form-container textarea {
            height: 100px;
            resize: vertical;
        }

        .message {
            text-align: center;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <h1>Add New Food 🍕</h1>

    <div class="form-container">

        <?php if ($message != ""): ?>

            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php endif; ?>

        <form method="POST">

            <label>Food Name:</label>
            <br>

            <input
                type="text"
                name="name"
                required
            >

            <br><br>

            <label>Description:</label>
            <br>

            <textarea
                name="description"
                required
            ></textarea>

            <br><br>

            <label>Price:</label>
            <br>

            <input
                type="number"
                name="price"
                step="0.01"
                required
            >

            <br><br>

            <label>Image Name:</label>
            <br>

            <input
                type="text"
                name="image"
                placeholder="pizza.jpg"
            >

            <br><br>

            <label>Category:</label>
            <br>

            <input
                type="text"
                name="category"
                required
            >

            <br><br>

            <button type="submit">
                Add Food
            </button>

        </form>

        <br>

        <a href="admin_dashboard.php">
            Back to Dashboard
        </a>

    </div>

</body>

</html>