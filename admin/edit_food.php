<?php

session_start();
require_once "../db_connection.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: manage_food.php");
    exit();
}

$id = $_GET["id"];
$message = "";

$sql = "SELECT * FROM food_items WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows != 1) {
    echo "Food item not found.";
    exit();
}

$food = $result->fetch_assoc();

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_POST["image"];
    $category = $_POST["category"];

    $sql = "UPDATE food_items
            SET name = ?,
                description = ?,
                price = ?,
                image = ?,
                category = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssdssi",
        $name,
        $description,
        $price,
        $image,
        $category,
        $id
    );

    if ($stmt->execute()) {

        $message = "Food updated successfully!";

        $food["name"] = $name;
        $food["description"] = $description;
        $food["price"] = $price;
        $food["image"] = $image;
        $food["category"] = $category;

    } else {

        $message = "Failed to update food.";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Food</title>

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

    <h1>Edit Food ✏️</h1>

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
                value="<?php echo htmlspecialchars($food["name"]); ?>"
                required
            >

            <br><br>

            <label>Description:</label>
            <br>

            <textarea
                name="description"
                required
            ><?php echo htmlspecialchars($food["description"]); ?></textarea>

            <br><br>

            <label>Price:</label>
            <br>

            <input
                type="number"
                name="price"
                step="0.01"
                value="<?php echo $food["price"]; ?>"
                required
            >

            <br><br>

            <label>Image Name:</label>
            <br>

            <input
                type="text"
                name="image"
                value="<?php echo htmlspecialchars($food["image"]); ?>"
            >

            <br><br>

            <label>Category:</label>
            <br>

            <input
                type="text"
                name="category"
                value="<?php echo htmlspecialchars($food["category"]); ?>"
                required
            >

            <br><br>

            <button type="submit">
                Update Food
            </button>

        </form>

        <br>

        <a href="manage_food.php">
            Back to Manage Food
        </a>

        <br><br>

        <a href="admin_dashboard.php">
            Back to Dashboard
        </a>

    </div>

</body>

</html>