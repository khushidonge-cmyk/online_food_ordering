<?php

session_start();
require_once "../db_connection.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT * FROM food_items ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Food</title>

    <link rel="stylesheet" href="admin_style.css">

    <style>

        .table-container {
            overflow-x: auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .actions a {
            margin-right: 8px;
        }

        .top-links {
            text-align: center;
            margin: 25px;
        }

    </style>

</head>

<body>

    <h1>Manage Food 🍔</h1>

    <div class="table-container">

        <table>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Action</th>

            </tr>

            <?php while ($food = $result->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?php echo $food["id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($food["name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($food["description"]); ?>
                    </td>

                    <td>
                        ₹<?php echo $food["price"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($food["category"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($food["image"]); ?>
                    </td>

                    <td class="actions">

                        <a href="edit_food.php?id=<?php echo $food["id"]; ?>">
                            Edit
                        </a>

                        |

                        <a
                            href="delete_food.php?id=<?php echo $food["id"]; ?>"
                            onclick="return confirm('Are you sure you want to delete this food?');"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    </div>

    <div class="top-links">

        <a href="add_food.php">
            Add New Food
        </a>

        <br><br>

        <a href="admin_dashboard.php">
            Back to Dashboard
        </a>

    </div>

</body>

</html>