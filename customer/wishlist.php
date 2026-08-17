<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../database/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Relational INNER JOIN query pulling saved items
$stmt = $conn->prepare("SELECT b.*, w.created_at AS added_date 
                        FROM wishlist w 
                        JOIN books b ON w.book_id = b.book_id 
                        WHERE w.user_id = ? 
                        ORDER BY w.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - BookLoop Marketplace</title>
    <link rel="stylesheet" href="../css/wishlist.css">
</head>
<body>

<?php include "../includes/header.php"; ?>

<div class="wishlist-container">
    <h2>My Saved Wishlist</h2>

    <?php if ($result->num_rows === 0): ?>
        <p class="empty-msg">Your wishlist is currently empty <a href="browse_books.php">Explore books</a> to add items.</p>
    <?php else: ?>
        <div class="wishlist-grid">
            <?php while ($book = $result->fetch_assoc()): ?>
                <div class="wishlist-card">
                    <img src="../image/<?php echo htmlspecialchars($book['image'] ? $book['image'] : 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($book['title']); ?>">
                    
                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="author">By <?php echo htmlspecialchars($book['author']); ?></p>
                    <p class="price">$<?php echo number_format($book['price'], 2); ?></p>
                    
                    <div class="card-actions">
                        <a href="book_detail.php?id=<?php echo $book['book_id']; ?>" class="btn btn-primary">View Details</a>
                        <a href="wishlist_action.php?action=remove&book_id=<?php echo $book['book_id']; ?>" class="btn btn-danger">Remove</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>