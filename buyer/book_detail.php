<?php
include '../config/db.php';
include '../includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle Review Submission (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<p style='color:red;'>You must be logged in to post a review.</p>";
    } else {
        $rating = intval($_POST['rating']);
        $comment = trim($_POST['comment']);
        $user_id = $_SESSION['user_id'];

		// prepare and bind
        $rev_stmt = $conn->prepare("INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $rev_stmt->bind_param("iiis", $id, $user_id, $rating, $comment);
        $rev_stmt->execute();
    }
}

// Fetch Book Details (Read)
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    echo "<p>Book not found</p>";
    exit();
}

// Fetch Reviews (Read)
$rev_fetch = $conn->prepare("SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.book_id = ? ORDER BY r.created_at DESC");
$rev_fetch->bind_param("i", $id);
$rev_fetch->execute();
$reviews = $rev_fetch->get_result();

$image_file = !empty($book['image']) ? $book['image'] : 'default_book.jpg';
?>

<div class="book-detail-container" >
	<div class="book-detail-img-wrapper">
        <img src="../images/<?php echo htmlspecialchars($image_file); ?>" 
             alt="<?php echo htmlspecialchars($book['title']); ?>" 
             class="book-detail-img">
    </div>
	
	<div class='book-detail-info'>
		<h2><?php echo htmlspecialchars($book['title']); ?></h2>
		<p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
		<p><strong>Genre:</strong> <?php echo htmlspecialchars($book['genre']); ?></p>
		<p><strong>Language:</strong> <?php echo htmlspecialchars($book['language'] ?? 'English'); ?></p>
		<p><strong>Condition:</strong> <?php echo htmlspecialchars($book['book_condition']); ?></p>
		<p class="price">$<?php echo number_format($book['price'], 2); ?></p>
		<p><strong>Description:</strong></p>
		<p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
		<br>
		
		<form action="cart.php" method="POST">
			<input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
			<input type="hidden" name="action" value="add">
			<label for="quantity">Quantity:</label>
			<input type="number" name="quantity" value="1" min="1" max="10" style="padding: 5px; width: 60px;">
			
			<button type="submit" class="btn">Add to Cart</button>
		</form>
	</div>
</div>

<br>
<div style="background: white; padding: 20px; border-radius: 8px;">
    <h3>Customer Reviews</h3>
    <br>
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="book_detail.php?id=<?php echo $id; ?>" method="POST" style="margin-bottom: 20px;">
            <p>
                <label>Rating:</label>
                <select name="rating" required>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Terrible</option>
                </select>
            </p> <br>
			
            <p>
				<textarea name="comment" required placeholder="Write your review here..." style="width: 100%; height: 80px; padding: 8px;"></textarea>
			</p> <br>
            
			<button type="submit" name="submit_review" class="btn">Submit Review</button>
        </form>
		
    <?php else: ?>
        <p><a href="login.php">Login</a> to leave a review.</p>
    <?php endif; ?>

    <?php if ($reviews->num_rows > 0): ?>
        <?php while ($r = $reviews->fetch_assoc()): ?>
            <div style="border-top: 1px solid #ddd; padding: 10px 0;">
                <strong><?php echo htmlspecialchars($r['name']); ?></strong> (Rating: <?php echo $r['rating']; ?>/5)
                <p><?php echo htmlspecialchars($r['comment']); ?></p>
                <small style="color: #777;"><?php echo $r['created_at']; ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reviews yet. Be the first to review!</p>
    <?php endif; ?>
</div>

</body>
</html>