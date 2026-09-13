<?php 
session_start(); 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Online Food Ordering</title>

    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">
</head> 
 
<body> 
 
    <h1>Welcome to Online Food Ordering System</h1> 
 
    <p>Order your favourite food online!</p> 
 
    <hr> 
 
    <?php if (isset($_SESSION["user_id"])): ?> 
 
        <h2>Welcome, <?php echo $_SESSION["user_name"]; ?>!</h2> 
 
        <a href="menu.php">View Food Menu</a> 
 
        <br><br> 
 
        <a href="logout.php">Logout</a> 
 
    <?php else: ?> 
 
        <a href="register.php">Register</a> 
 
        <br><br> 
 
        <a href="login.php">Login</a> 
 
        <br><br> 
 
        <a href="menu.php">View Food Menu</a> 
 
    <?php endif; ?> 
 
</body> 
 
</html>