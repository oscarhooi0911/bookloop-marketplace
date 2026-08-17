<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

// Buyer features available only for  signed in customer
if ($_SESSION['role'] !== 'customer') {
    header('Location: ../staff/dashboard.php');
    exit();
}

// filter
$search = trim($_GET['search'] ?? '');
$genre = trim($_GET['genre'] ?? '');
$language = trim($_GET['language'] ?? '');
$sql = 'SELECT book_id, title, author, genre, language, price, book_condition, image FROM books WHERE 1=1';
$params = [];
$types = '';

if ($search !== '') {
    $sql .= ' AND (title LIKE ? OR author LIKE ?)';
    $term = "%{$search}%";
    $params[] = $term;
    $params[] = $term;
    $types .= 'ss';
}
if ($genre !== '') {
    $sql .= ' AND genre = ?';
    $params[] = $genre;
    $types .= 's';
}
if ($language !== '') {
    $sql .= ' AND language = ?';
    $params[] = $language;
    $types .= 's';
}
$sql .= ' ORDER BY created_at DESC, book_id DESC';
$stmt = mysqli_prepare($conn, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$books = mysqli_stmt_get_result($stmt);
$genres = mysqli_query($conn, 'SELECT DISTINCT genre FROM books ORDER BY genre');
$languages = mysqli_query($conn, 'SELECT DISTINCT language FROM books ORDER BY language');
require_once "../includes/header.php";
?>

<div class="container browse-container">
    <div class="browse-header">
        <div>
            <h2>Browse books</h2>
            <p class="browse-subtitle">
                Find your next pre-loved read.
            </p>
        </div>
        <a class="custom-button" href="cart.php">
            View cart
        </a>
    </div>
    <form method="get" class="search-box">
        <div class="search-row">
            <div class="search-input">
                <input name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search title or author">
            </div>
            <div class="search-select">
                <select name="genre">
                    <option value="">All genres</option>
                    <?php while ($item = mysqli_fetch_assoc($genres)): ?>
                        <option value="<?= htmlspecialchars($item['genre']) ?>"
                            <?= $genre === $item['genre'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($item['genre']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="search-select">
                <select name="language">
                    <option value="">
                        All languages
                    </option>
                    <?php while ($item = mysqli_fetch_assoc($languages)): ?>

                        <option value="<?= htmlspecialchars($item['language']) ?>"
                            <?= $language === $item['language'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($item['language']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="search-button">
                <button type="submit" class="custom-button">
                    Search
                </button>
            </div>
        </div>
    </form>
    <div class="book-grid">
        <?php while ($book = mysqli_fetch_assoc($books)): ?>
            <div class="book-card">
                <?php if (!empty($book['image'])): ?>
                    <img class="book-card-image" src="../images/<?= rawurlencode($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                <?php endif; ?>
                <div class="book-card-content">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
                    <p class="book-info"><?= htmlspecialchars($book['genre']) ?>·<?= htmlspecialchars($book['language']) ?></p>
                    <p class="book-price">$<?= number_format((float) $book['price'], 2) ?></p>
                    <a class="custom-button book-detail-button" href="book_detail.php?id=<?= (int) $book['book_id'] ?>">
                        View details
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php require_once "../includes/footer.php"; ?>
