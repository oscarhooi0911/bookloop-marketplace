<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

if ($_SESSION['role'] !== 'customer') {
    header('Location: ../staff/dashboard.php');
    exit();
}
// missing or invalid ID returns the customer to the catalogue
$bookId = (int) ($_GET['id'] ?? 0);
if ($bookId < 1) {
    header('Location: browse_books.php');
    exit();
}

// Store a review only after validate the rate and comment.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = (int) ($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        $review = mysqli_prepare($conn, 'INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (?, ?, ?, ?)');
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

// check wishlist
$userId = (int) $_SESSION['user_id'];
$wishCheck = mysqli_prepare($conn, 'SELECT wishlist_id FROM wishlist WHERE user_id = ? AND book_id = ?');
mysqli_stmt_bind_param($wishCheck, 'ii', $userId, $bookId);
mysqli_stmt_execute($wishCheck);
$inWishlist = mysqli_num_rows(mysqli_stmt_get_result($wishCheck)) > 0;

// Fetch reviews
$reviews = mysqli_prepare($conn, 'SELECT r.rating, 
							r.comment, r.created_at, 
							u.full_name FROM reviews r 
							INNER JOIN users u 
							ON u.user_id = r.user_id WHERE r.book_id = ? 
							ORDER BY r.created_at DESC');
mysqli_stmt_bind_param($reviews, 'i', $bookId);
mysqli_stmt_execute($reviews);
$reviews = mysqli_stmt_get_result($reviews);
require_once "../includes/header.php";
?>
<div class="container py-5">
    <a class="text-decoration-none" href="browse_books.php">Back to books</a>
    <div class="card shadow-sm mt-3">
		<div class="row g-0">
			<div class="col-md-4"><?php if (!empty($book['image'])): ?><img class="img-fluid rounded-start w-100" style="height:360px;object-fit:cover" src="../images/<?= rawurlencode($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>"><?php endif; ?></div>
				<div class="col-md-8"><div class="card-body h-100 d-flex flex-column">
					<h2><?= htmlspecialchars($book['title']) ?></h2>
					<p class="lead text-muted"><?= htmlspecialchars($book['author']) ?></p>
					<p><?= htmlspecialchars($book['genre']) ?> · <?= htmlspecialchars($book['language']) ?> · <?= htmlspecialchars($book['book_condition']) ?></p>
					<p><?= nl2br(htmlspecialchars($book['description'] ?? '')) ?></p>
					<p class="fs-4 fw-bold text-success mt-auto">$<?= number_format((float) $book['price'], 2) ?></p>
					
					<form action="cart.php" method="post" class="d-flex gap-2 align-items-center">
						<input type="hidden" name="action" value="add">
						<input type="hidden" name="book_id" value="<?= $bookId ?>">
						<input type="number" class="form-control" style="max-width:90px" name="quantity" value="1" min="1" max="10">
						<button class="btn btn-primary">Add to cart</button>

						<?php if ($inWishlist): ?>
                            <a href="wishlist_action.php?action=remove&book_id=<?= $bookId ?>" class="btn btn-outline-danger">Remove from wishlist</a>
                        <?php else: ?>
                            <a href="wishlist_action.php?action=add&book_id=<?= $bookId ?>" class="btn btn-outline-secondary">Add to wishlist</a>
                        <?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	</div>
	
    <section class="card shadow-sm mt-4">
		<div class="card-body">
			<h3>Customer reviews</h3>
			<form method="post" class="mt-3 mb-4">
				<div class="mb-3">
					<label class="form-label" for="rating">Rating</label>
					<select class="form-select" id="rating" name="rating">
						<option value="5">5 — Excellent</option>
						<option value="4">4 — Good</option>
						<option value="3">3 — Average</option>
						<option value="2">2 — Poor</option>
						<option value="1">1 — Terrible</option>
					</select>
				</div>
					<div class="mb-3"><label class="form-label" for="comment">Your review</label>
					<textarea class="form-control" id="comment" name="comment" required maxlength="2000"></textarea>
					</div>
					<button class="btn btn-primary" name="submit_review">Submit review</button>
			</form>
			<?php if (mysqli_num_rows($reviews) === 0): ?>
			<p class="text-muted mb-0">No reviews yet.</p>
			<?php else: while ($review = mysqli_fetch_assoc($reviews)): ?>
			<article class="border-top py-3">
				<strong><?= htmlspecialchars($review['full_name']) ?></strong> 
				<span class="text-warning">★ <?= (int) $review['rating'] ?>/5</span>
				<p class="mb-1"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
				<small class="text-muted"><?= htmlspecialchars($review['created_at']) ?></small>
			</article>
			<?php endwhile; endif; ?>
		</div>
	</section>
</div>
<?php require_once "../includes/footer.php"; ?>
