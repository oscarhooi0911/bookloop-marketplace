<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

if ($_SESSION['role'] !== 'customer') {
    header("Location: ../staff/dashboard.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['book_id'] ?? 0);

$error = "";

/*
    Only retrieve a book
    belonging to current seller
*/
$stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE book_id=? AND seller_id=?");
mysqli_stmt_bind_param($stmt, "ii", $book_id, $seller_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    header("Location: my_books.php");
    exit();
}

/*
    Update book
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $language = trim($_POST['language'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 0);
    $book_condition = trim($_POST['book_condition'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_name = $book['image'];

    if ($title === '' || $author === '' || $genre === '' || $language === '' || $book_condition === '') {
        $error = "Please fill in all required fields.";
    } elseif ($price <= 0) {
        $error = "Price must be greater than 0.";
    } elseif ($quantity < 1) {
        $error = "Quantity must be at least 1.";
    }

    /*
        New image
    */
    if ($error === '' && isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $error = "Image upload failed.";
        } else {
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($extension, $allowed)) {
                $error = "Only JPG, JPEG, PNG or GIF images are allowed.";
            } else {
                $new_image_name = time() . '_' . basename($_FILES['image']['name']);
                $target = "../image/" . $new_image_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $image_name = $new_image_name;
                } else {
                    $error = "Unable to save the uploaded image.";
                }
            }
        }
    }

    /* Update SQL */
    if ($error === '') {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE books
             SET
                title=?,
                author=?,
                genre=?,
                language=?,
                price=?,
                quantity=?,
                book_condition=?,
                description=?,
                image=?
             WHERE
                book_id=?
                AND seller_id=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssssdisssii",
            $title,
            $author,
            $genre,
            $language,
            $price,
            $quantity,
            $book_condition,
            $description,
            $image_name,
            $book_id,
            $seller_id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: my_books.php?success=updated");
            exit();
        } else {
            $error = "Unable to update the book. Please try again.";
        }
    }

    /*
        Keep entered values
        if validation fails
    */
    $book['title'] = $title;
    $book['author'] = $author;
    $book['genre'] = $genre;
    $book['language'] = $language;
    $book['price'] = $price;
    $book['quantity'] = $quantity;
    $book['book_condition'] = $book_condition;
    $book['description'] = $description;
}

require_once "../includes/header.php";
?>

<link rel="stylesheet" href="../css/seller.css">

<section class="seller-page">
	<div class="seller-form-container">
		<div class="seller-form-header">
			<div>
				<h1>Edit Book</h1>
				<p>Update your book listing information.</p>
			</div>
			
			<a class="seller-back-link" href="my_books.php">Back to My Books</a>
		</div>

		<?php if ($error !== ''): ?>
			<div class="seller-message error">
				<?php echo htmlspecialchars($error); ?>
			</div>
		<?php endif; ?>

		<div id="clientError" class="seller-message error" hidden></div>
		<form id="bookForm" class="seller-form" method="post" enctype="multipart/form-data" novalidate>
			<input type="hidden" name="book_id" value="<?php echo (int)$book_id; ?>">

			<div class="seller-form-grid">

				<div class="seller-field full-width">
					<label for="title">Book Title *</label>
					<input
						id="title"
						name="title"
						type="text"
						maxlength="150"
						required
						value="<?php echo htmlspecialchars($book['title']); ?>"
					>
				</div>

				<div class="seller-field">
					<label for="author">Author *</label>
					<input
						id="author"
						name="author"
						type="text"
						maxlength="100"
						required
						value="<?php echo htmlspecialchars($book['author']); ?>"
					>
				</div>

				<div class="seller-field">
					<label for="genre">Genre *</label>
					<select id="genre" name="genre" required>
						<?php
						$genres = [
							'Textbook',
							'Technology',
							'Fiction',
							'Novel',
							'Business',
							'Self-help',
							'Other'
						];

						foreach ($genres as $item) {
							$selected = $book['genre'] === $item ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($item) . '" ' . $selected . '>' . htmlspecialchars($item) . '</option>';
						}
						?>
					</select>
				</div>

				<div class="seller-field">
					<label for="language">Language *</label>
					<select id="language" name="language" required>
						<?php
						$languages = [
							'English',
							'Mandarin',
							'Malay',
							'Other'
						];

						foreach ($languages as $item) {
							$selected = $book['language'] === $item ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($item) . '" ' . $selected . '>' . htmlspecialchars($item) . '</option>';
						}
						?>
					</select>
				</div>

				<div class="seller-field">
					<label for="book_condition">Condition *</label>
					<select id="book_condition" name="book_condition" required>
						<?php
						$conditions = [
							'Used - Like New',
							'Used - Good',
							'Used - Acceptable'
						];

						foreach ($conditions as $item) {
							$selected = $book['book_condition'] === $item ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($item) . '" ' . $selected . '>' . htmlspecialchars($item) . '</option>';
						}
						?>
					</select>
				</div>

				<div class="seller-field">
					<label for="price">Price (RM) *</label>
					<input
						id="price"
						name="price"
						type="number"
						min="0.01"
						step="0.01"
						required
						value="<?php echo htmlspecialchars($book['price']); ?>"
					>
				</div>

				<div class="seller-field">
					<label for="quantity">Quantity *</label>
					<input
						id="quantity"
						name="quantity"
						type="number"
						min="1"
						step="1"
						required
						value="<?php echo (int)$book['quantity']; ?>"
					>
				</div>

				<div class="seller-field full-width">
					<label for="description">Description</label>
					<textarea
						id="description"
						name="description"
						rows="5"
						maxlength="800"
					><?php echo htmlspecialchars($book['description'] ?? ''); ?></textarea>
					<small id="descriptionCount">0 / 800 characters</small>
				</div>

				<div class="seller-field full-width">
					<label for="image">Replace Book Image</label>

					<?php if (!empty($book['image'])): ?>
						<div class="seller-current-image">
							<img
								src="../images/<?php echo rawurlencode($book['image']); ?>"
								alt="Current book image"
							>
							<span>
								Current image: <?php echo htmlspecialchars($book['image']); ?>
							</span>
						</div>
					<?php endif; ?>

					<input
						id="image"
						name="image"
						type="file"
						accept=".jpg,.jpeg,.png,.gif"
					>
					<small>Leave empty to keep the current image.</small>
				</div>

			</div>

			<div id="listingPreview" class="seller-preview">
				<strong>Listing summary:</strong>
				<span id="previewText"></span>
			</div>

			<div class="seller-form-actions">
				<a class="seller-btn seller-btn-secondary" href="my_books.php">
					Cancel
				</a>
				<button class="seller-btn seller-btn-primary" type="submit">Save Changes</button>
			</div>
		</form>
	</div>
</section>

<script src="seller.js"></script>

<?php 
require_once "../includes/footer.php"; 
?>
