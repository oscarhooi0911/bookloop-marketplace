<?php

require_once "../authentication/check_staff.php";
require_once "../database/database.php";

//search book
$search = trim($_GET['search'] ?? '');
$genre = trim($_GET['genre'] ?? '');
$language = trim($_GET['language'] ?? '');

//get books
$sql = '
    SELECT
        book_id,
        title,
        author,
        genre,
        language,
        price,
        book_condition,
        image
    FROM books
    WHERE 1=1
';

$params = [];
$types = '';

/* Search title or author */
if ($search !== '') {
    $sql .= ' AND (title LIKE ? OR author LIKE ?)';
    $term = "%{$search}%";
    $params[] = $term;
    $params[] = $term;
    $types .= 'ss';
}

/* Filter genre */
if ($genre !== '') {
    $sql .= ' AND genre = ?';
    $params[] = $genre;
    $types .= 's';
}

/* Filter language */
if ($language !== '') {
    $sql .= ' AND language = ?';
    $params[] = $language;
    $types .= 's';
}

$sql .= ' ORDER BY created_at DESC, book_id DESC';

/* Prepare */
$stmt = mysqli_prepare($conn, $sql);

if ($params) {
    mysqli_stmt_bind_param(
        $stmt,
        $types,
        ...$params
    );
}


mysqli_stmt_execute($stmt);

$books = mysqli_stmt_get_result($stmt);


//get genres
$genres = mysqli_query(
    $conn,
    'SELECT DISTINCT genre FROM books ORDER BY genre'
);

//get language/
$languages = mysqli_query(
    $conn,
    'SELECT DISTINCT language FROM books ORDER BY language'
);

//Number of the books
$total_books = mysqli_num_rows($books);

require_once "../includes/header.php";

?>

<div class="manage-books-page">
	<div class="manage-books-header">
		<div>
			<h2>Manage Books</h2>
			<p>View and manage books listed on the marketplace.</p>
		</div>
		
		<div class="book-count">
			<span>Total Books</span>
			<strong><?= $total_books ?></strong>
		</div>
	</div>

	<!--Filter-->
	<div class="manage-books-search">
	
		<form method="get">

			<div class="manage-books-search-input">
				<input
					type="text"
					name="search"
					placeholder="Search title or author"
					value="<?= htmlspecialchars($search) ?>"
				>
			</div>


			<div class="manage-books-search-select">
				<select name="genre">
					<option value="">All genres</option>
					<?php while ($item = mysqli_fetch_assoc($genres)): ?>
						<option
							value="<?= htmlspecialchars($item['genre']) ?>"
							<?= $genre === $item['genre'] ? 'selected' : '' ?>
						>
							<?= htmlspecialchars($item['genre']) ?>
						</option>
					<?php endwhile; ?>
				</select>
			</div>

			<div class="manage-books-search-select">
				<select name="language">
					<option value="">All languages</option>
					<?php while ($item = mysqli_fetch_assoc($languages)): ?>
						<option
							value="<?= htmlspecialchars($item['language']) ?>"
							<?= $language === $item['language'] ? 'selected' : '' ?>
						>
							<?= htmlspecialchars($item['language']) ?>
						</option>
					<?php endwhile; ?>
				</select>
			</div>

			<button type="submit">Search</button>
			<a href="manage_books.php">Clear</a>
		</form>
	</div>

	<!--book table-->
	<div class="books-table-container">

		<table class="books-table">
		
			<thead>
				<tr>
					<th>ID</th>
					<th>Book</th>
					<th>Author</th>
					<th>Genre</th>
					<th>Language</th>
					<th>Price</th>
					<th>Condition</th>
					<th>Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if (mysqli_num_rows($books) > 0): ?>
					<?php while ($book = mysqli_fetch_assoc($books)): ?>
						<tr>
							<td><?= (int) $book['book_id'] ?></td>
							<td class="book-name">
								<?php if (!empty($book['image'])): ?>
									<img
										src="../images/<?= rawurlencode($book['image']) ?>"
										alt="<?= htmlspecialchars($book['title']) ?>"
									>
								<?php endif; ?>
								<strong><?= htmlspecialchars($book['title']) ?></strong>
							</td>
							
							<td><?= htmlspecialchars($book['author']) ?></td>
							<td><?= htmlspecialchars($book['genre']) ?></td>
							<td><?= htmlspecialchars($book['language']) ?></td>
							<td class="book-price">$<?= number_format((float) $book['price'], 2) ?></td>
							<td>
								<span class="book-condition"><?= htmlspecialchars($book['book_condition']) ?></span>
							</td>
							
							<td>
								<div class="book-actions">
									<a
										href="../customer/book_detail.php?id=<?= (int) $book['book_id'] ?>"
										class="book-action-view"
									>
										View
									</a>

									<a
										href="delete_book.php?id=<?= (int) $book['book_id'] ?>"
										class="book-action-delete"
										onclick="return confirm('Are you sure you want to delete this book?');"
									>
										Delete
									</a>
								</div>
							</td>
						</tr>

					<?php endwhile; ?>
					
				<?php else: ?>
					<tr>
						<td colspan="8" class="no-books">No books found.</td>
					</tr>
				<?php endif; ?>
				
			</tbody>
		</table>
	</div>
</div>

<?php 
require_once "../includes/footer.php"; 
?>
