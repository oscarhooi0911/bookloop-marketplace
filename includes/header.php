<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second-Hand Bookstore</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<header>
    <h1>Second-Hand Book Market</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="browse_book.php">Browse Books</a>
        <a href="cart.php">Cart</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
<div class="container">