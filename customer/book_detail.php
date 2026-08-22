<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

if ($_SESSION['role'] !== 'customer') {
    header('Location: ../staff/dashboard.php');
    exit();
}

$bookId = (int) ($_GET['id'] ?? 0);

if ($bookId < 1) {
    header('Location: browse_books.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = (int) ($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        $review = mysqli_prepare($conn,'INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (?, ?, ?, ?)');
        $userId = (int) $_SESSION['user_id'];
        mysqli_stmt_bind_param($review, 'iiis', $bookId, $userId, $rating, $comment);
        mysqli_stmt_execute($review);
    }

    header("Location: book_detail.php?id={$bookId}");
    exit();
}

// Fetch book details
$stmt = mysqli_prepare($conn, 'SELECT * FROM books WHERE book_id = ?');
mysqli_stmt_bind_param($stmt, 'i', $bookId);
mysqli_stmt_execute($stmt);
$book = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$book) {
    header('Location: browse_books.php');
    exit();
}

// Check wishlist status
$userId = (int) $_SESSION['user_id'];
$wishCheck = mysqli_prepare($conn, 'SELECT wishlist_id FROM wishlist WHERE user_id = ? AND book_id = ?');
mysqli_stmt_bind_param($wishCheck, 'ii', $userId, $bookId);
mysqli_stmt_execute($wishCheck);
$inWishlist = mysqli_num_rows(mysqli_stmt_get_result($wishCheck)) > 0;

// Fetch reviews
$reviewsStmt = mysqli_prepare(
    $conn,
    'SELECT r.rating, r.comment, r.created_at, u.full_name
     FROM reviews r
     INNER JOIN users u ON u.user_id = r.user_id
     WHERE r.book_id = ?
     ORDER BY r.created_at DESC'
);
mysqli_stmt_bind_param($reviewsStmt, 'i', $bookId);
mysqli_stmt_execute($reviewsStmt);
$reviews = mysqli_stmt_get_result($reviewsStmt);

require_once "../includes/header.php";
?>

<div class="container book-detail-page">
	<a class="custom-btn" href="browse_books.php">Back to books</a> <br><br>

	<div class="book-detail-card">
		<div class="book-detail-layout">
			<div class="book-detail-image-section">
				<?php if (!empty($book['image'])): ?>
					<img class="book-detail-main-image" src="../images/<?= rawurlencode($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
				<?php endif; ?>
			</div>

			<div class="book-detail-content">
				<h2><?= htmlspecialchars($book['title']) ?></h2>
				<p class="book-detail-author"><?= htmlspecialchars($book['author']) ?></p>
				<p class="book-detail-info">
					<?= htmlspecialchars($book['genre']) ?> · <?= htmlspecialchars($book['language']) ?> · <?= htmlspecialchars($book['book_condition']) ?>
				</p>
				<p class="book-description">
					<?= nl2br(htmlspecialchars($book['description'] ?? '')) ?>
				</p>
				<p class="book-detail-price">
					$<?= number_format((float) $book['price'], 2) ?>
				</p>

				<form action="cart.php" method="post" class="cart-form">
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="book_id" value="<?= $bookId ?>">
					<input type="number" class="quantity-input" name="quantity" value="1" min="1" max="10">
					<button type="submit" class="custom-btn">Add to cart</button>

					<?php if ($inWishlist): ?>
						<a href="wishlist_action.php?action=remove&book_id=<?= $bookId ?>" class="custom-btn">Remove from wishlist</a>
					<?php else: ?>
						<a href="wishlist_action.php?action=add&book_id=<?= $bookId ?>" class="custom-btn">Add to wishlist</a>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>

	<section class="reviews-card">
		<div class="reviews-content">
			<h3>Customer reviews</h3>

			<form method="post" class="review-form">
				<div class="form-group">
					<label for="rating">Rating</label>
					<select id="rating" name="rating">
						<option value="5">5 — Excellent</option>
						<option value="4">4 — Good</option>
						<option value="3">3 — Average</option>
						<option value="2">2 — Poor</option>
						<option value="1">1 — Terrible</option>
					</select>
				</div>

				<div class="form-group">
					<label for="comment">Your review</label>
					<textarea id="comment" name="comment" required maxlength="2000"></textarea>
				</div>

				<button type="submit" class="custom-btn" name="submit_review">Submit review</button>
			</form>

			<?php if (mysqli_num_rows($reviews) === 0): ?>
				<p class="no-reviews">No reviews yet.</p>
			<?php else: ?>
				<?php while ($review = mysqli_fetch_assoc($reviews)): ?>
					<article class="review-item">
						<div class="review-header">
							<strong><?= htmlspecialchars($review['full_name']) ?></strong>
							<span class="review-rating">★<?= (int) $review['rating'] ?>/5</span>
						</div>
						<p class="review-comment"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
						<small class="review-date"><?= htmlspecialchars($review['created_at']) ?></small>
					</article>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</section>
</div>

<?php require_once "../includes/footer.php"; ?>