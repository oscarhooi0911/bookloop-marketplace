<?php
include '../config/db.php';
include '../includes/header.php';

$sql = "SELECT * FROM books ORDER BY book_id DESC LIMIT 3";
$result = $conn->query($sql);
?>

<div style="text-align: center; margin: 30px 0;">
    <h2>Welcome to Second-Hand Marketplace</h2>
    <p>Find affordable, pre-loved textbooks, literature, and general books!</p>
    <br>
    <a href="books.php" class="btn">Explore All Books</a>
</div>

<h3>Recently Added Books</h3>
<br>
<div class="book-grid">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-card">
                <div>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                    <p><strong>Condition:</strong> <?php echo htmlspecialchars($row['book_condition']); ?></p>
                    <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                </div>
                <a href="book_detail.php?id=<?php echo $row['book_id']; ?>" class="btn">View Details</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No books currently available</p>
    <?php endif; ?>
</div>

</body>
</html>