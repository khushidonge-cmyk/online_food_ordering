<?php

require_once "db_connection.php";

$sql = "SELECT * FROM food_items";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Food Menu</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .menu-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .food-card {
            background-color: white;
            width: 250px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        /* Food Image */
        .food-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .food-card h2 {
            color: #e67e22;
        }

        .food-card .price {
            font-size: 18px;
            font-weight: bold;
        }

        .food-card .category {
            color: #777;
        }

    </style>

</head>

<body>

    <h1>Our Food Menu 🍽️</h1>

    <div class="menu-container">

        <?php

        if ($result->num_rows > 0) {

            while ($food = $result->fetch_assoc()) {

        ?>

            <div class="food-card">

                <!-- Food Image -->
                <img
                    src="images/<?php echo htmlspecialchars($food["image"]); ?>"
                    alt="<?php echo htmlspecialchars($food["name"]); ?>"
                >

                <!-- Food Name -->
                <h2>
                    <?php echo htmlspecialchars($food["name"]); ?>
                </h2>

                <!-- Description -->
                <p>
                    <?php echo htmlspecialchars($food["description"]); ?>
                </p>

                <!-- Price -->
                <p class="price">
                    ₹<?php echo $food["price"]; ?>
                </p>

                <!-- Category -->
                <p class="category">
                    Category:
                    <?php echo htmlspecialchars($food["category"]); ?>
                </p>

                <!-- Add To Cart -->
                <a href="add_to_cart.php?food_id=<?php echo $food["id"]; ?>">
                    <button>
                        Add to Cart 🛒
                    </button>
                </a>

            </div>

        <?php

            }

        } else {

            echo "<p>No food items available.</p>";

        }

        ?>

    </div>

    <br><br>

    <center>

        <a href="cart.php">
            View Cart 🛒
        </a>

        <br><br>

        <a href="index.php">
            Back to Home
        </a>

    </center>

</body>

</html>