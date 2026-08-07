<?php
include '../config/db.php';
include '../includes/header.php';

$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<h2>All Available Books</h2>
<div class="book-grid">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-card">
                <div>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
					<p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                    <p><strong>Language:</strong> <?php echo htmlspecialchars($row['language'] ?? 'English'); ?></p>
                    <p><strong>Condition:</strong> <?php echo htmlspecialchars($row['book_condition']); ?></p>
                    <p class="price"><strong>Price: </strong> $ <?php echo number_format($row['price'], 2); ?></p>
                </div>
                <a href="book_detail.php?id=<?php echo $row['book_id']; ?>" class="btn">View Details</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No books currently available.</p>
    <?php endif; ?>
</div>

</body>
</html>