<?php
include '../config/db.php';
include '../includes/header.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';
$language = isset($_GET['language']) ? trim($_GET['language']) : '';

$sql = "SELECT * FROM books WHERE 1=1";
$params = [];
$types = "";

if ($search !== '') {
    $sql .= " AND (title LIKE ? OR author LIKE ?)";
    $searchTerm = "%" . $search . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "ss";
}

if ($genre !== '') {
    $sql .= " AND genre = ?";
    $params[] = $genre;
    $types .= "s";
}

if ($language !== '') {
    $sql .= " AND language = ?";
    $params[] = $language;
    $types .= "s";
}

$stmt = $conn -> prepare($sql);
if (!empty($params)) {
    $stmt -> bind_param($types, ...$params);
}
$stmt -> execute();
$result = $stmt -> get_result();
?>

<h2>Search & Browse Books</h2>
<br>
<form method="GET" action="browse_book.php" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search title or author..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 8px; width: 250px;">
    
	<br><br>
	<select name="genre" style="padding: 8px;"> 
        <option value="">All Genres</option>
        <option value="Textbook" <?php if ($genre==='Novel') echo 'selected'; ?>>Textbook</option>
        <option value="Technology" <?php if ($genre==='Technology') echo 'selected'; ?>>Technology</option>
        <option value="Fiction" <?php if ($genre==='Fiction') echo 'selected'; ?>>Fiction</option>
    </select> 
	
	<br><br>
	<select name="language" style="padding: 8px;"> 
        <option value="">All Languages</option>
        <option value="English" <?php if ($language==='English') echo 'selected'; ?>>English</option>
        <option value="Mandarin" <?php if ($language==='Mandarin') echo 'selected'; ?>>Mandarin</option>
        <option value="Malay" <?php if ($language==='Malay') echo 'selected'; ?>>Malay</option>
		<option value="Others" <?php if ($language==='Others') echo 'selected'; ?>>Others</option>
    </select> 
	
	<br><br>
    <button type="submit" class="btn">Filter</button>
</form>

<div class="book-grid">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-card">
                <div>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                    <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
					<p><strong>Language:</strong> <?php echo htmlspecialchars($row['language']); ?></p>
                    <p class="price">$<?php echo number_format($row['price'], 2); ?></p>
                </div>
                <a href="book_detail.php?id=<?php echo $row['book_id']; ?>" class="btn">View Details</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No matching books found</p>
    <?php endif; ?>
</div>

</body>
</html>