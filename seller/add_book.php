<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

// Allow access to customers/sellers
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'customer' && $_SESSION['role'] !== 'seller')) {
    header("Location: ../staff/dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $seller_id = $_SESSION['user_id'];
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $language = trim($_POST['language'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $quantity = (int)($_POST['quantity'] ?? 0);
    $book_condition = trim($_POST['book_condition'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_name = null;

    if ($title === '' || $author === '' || $genre === '' || $language === '' || $book_condition === '') {
        $error = "Please fill in all required fields.";
    } elseif ($price <= 0) {
        $error = "Price must be greater than 0.";
    } elseif ($quantity < 1) {
        $error = "Quantity must be at least 1.";
    }

    /* Image upload */
    if ($error === '' && isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $error = "Image upload failed.";
        } else {
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($extension, $allowed)) {
                $error = "Only JPG, JPEG, PNG or GIF images are allowed.";
            } else {
                $image_name = basename($_FILES['image']['name']);
                
                // Ensure target folder exists
                $target_dir = "../images/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                $target = $target_dir . $image_name;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $error = "Unable to save the uploaded image.";
                }
            }
        }
    }

    /* Insert into database */
    if ($error === '') {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO books
            (seller_id, title, author, genre, language, price, quantity, book_condition, description, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "issssdisss",
            $seller_id,
            $title,
            $author,
            $genre,
            $language,
            $price,
            $quantity,
            $book_condition,
            $description,
            $image_name
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: my_books.php?success=added");
            exit();
        } else {
            $error = "Unable to add the book. Please try again.";
        }
    }
}

require_once "../includes/header.php";
?>

<link rel="stylesheet" href="../css/seller.css">

<section class="seller-page">
	<div class="seller-form-container">

		<div class="seller-form-header">
			<div>
				<h1>Sell a Book</h1>
				<p>Add a second-hand book to the marketplace.</p>
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
			<div class="seller-form-grid">

				<!-- Book Title -->
				<div class="seller-field full-width">
					<label for="title">Book Title *</label>
					<input id="title" name="title" type="text" maxlength="150" required value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
				</div>

				<!-- Author -->
				<div class="seller-field">
					<label for="author">Author *</label>
					<input id="author" name="author" type="text" maxlength="100" required value="<?php echo htmlspecialchars($_POST['author'] ?? ''); ?>">
				</div>

				<!-- Genre -->
				<div class="seller-field">
					<label for="genre">Genre *</label>
					<select id="genre" name="genre" required>
						<option value="">Choose genre</option>
						<?php
						$genres = ['Textbook', 'Technology', 'Fiction', 'Novel', 'Business', 'Self-help', 'Other'];
						$selectedGenre = $_POST['genre'] ?? '';
						foreach ($genres as $item) {
							$selected = ($selectedGenre === $item) ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($item) . '" ' . $selected . '>' . htmlspecialchars($item) . '</option>';
						}
						?>
					</select>
				</div>

				<!-- Language -->
				<div class="seller-field">
					<label for="language">Language *</label>
					<select id="language" name="language" required>
						<option value="">Choose language</option>
						<?php
						$languages = ['English', 'Mandarin', 'Malay', 'Other'];
						$selectedLanguage = $_POST['language'] ?? '';
						foreach ($languages as $item) {
							$selected = ($selectedLanguage === $item) ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($item) . '" ' . $selected . '>' . htmlspecialchars($item) . '</option>';
						}
						?>
					</select>
				</div>

				<!-- Condition -->
				<div class="seller-field">
					<label for="book_condition">Condition *</label>
					<select id="book_condition" name="book_condition" required>
						<option value="">Choose condition</option>
						<?php
						$conditions = ['Used - Like New', 'Used - Good', 'Used - Acceptable'];
						$selectedCondition = $_POST['book_condition'] ?? '';
						foreach ($conditions as $item) {
							$selected = ($selectedCondition === $item) ? 'selected' : '';
							echo '<option value="' . htmlspecialchars($item) . '" ' . $selected . '>' . htmlspecialchars($item) . '</option>';
						}
						?>
					</select>
				</div>

				<!-- Price -->
				<div class="seller-field">
					<label for="price">Price (RM) *</label>
					<input id="price" name="price" type="number" min="0.01" step="0.01" required value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>">
				</div>

				<!-- Quantity -->
				<div class="seller-field">
					<label for="quantity">Quantity *</label>
					<input id="quantity" name="quantity" type="number" min="1" step="1" required value="<?php echo htmlspecialchars($_POST['quantity'] ?? '1'); ?>">
				</div>

				<!-- Description -->
				<div class="seller-field full-width">
					<label for="description">Description</label>
					<textarea id="description" name="description" rows="5" maxlength="800"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
					<small id="descriptionCount">0 / 800 characters</small>
				</div>

				<!-- Image -->
				<div class="seller-field full-width">
					<label for="image">Book Image</label>
					<input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.gif">
					<small>Optional. JPG, JPEG, PNG or GIF.</small>
				</div>

			</div>

			<div id="listingPreview" class="seller-preview">
				<strong>Listing summary:</strong>
				<span id="previewText">Enter a price and quantity.</span>
			</div>

			<div class="seller-form-actions">
				<a class="seller-btn seller-btn-secondary" href="my_books.php">Cancel</a>
				<button class="seller-btn seller-btn-primary" type="submit">Add Book</button>
			</div>
		</form>
	</div>
</section>

<script src="seller.js"></script>

<?php 
require_once "../includes/footer.php"; 
?>