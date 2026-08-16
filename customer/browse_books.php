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

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h2 class="mb-1">Browse books</h2><p class="text-muted mb-0">Find your next pre-loved read.</p></div>
        <a class="btn btn-primary" href="cart.php">View cart</a>
    </div>
    <form method="get" class="card p-3 mb-4">
        <div class="row g-3">
            <div class="col-md-5"><input name="search" class="form-control" value="<?= htmlspecialchars($search) ?>" placeholder="Search title or author"></div>
            <div class="col-md-3"><select name="genre" class="form-select"><option value="">All genres</option><?php while ($item = mysqli_fetch_assoc($genres)): ?><option value="<?= htmlspecialchars($item['genre']) ?>" <?= $genre === $item['genre'] ? 'selected' : '' ?>><?= htmlspecialchars($item['genre']) ?></option><?php endwhile; ?></select></div>
            <div class="col-md-3"><select name="language" class="form-select"><option value="">All languages</option><?php while ($item = mysqli_fetch_assoc($languages)): ?><option value="<?= htmlspecialchars($item['language']) ?>" <?= $language === $item['language'] ? 'selected' : '' ?>><?= htmlspecialchars($item['language']) ?></option><?php endwhile; ?></select></div>
            <div class="col-md-1 d-grid"><button class="btn btn-primary">Search</button></div>
        </div>
    </form>
    <div class="row g-4">
        <?php while ($book = mysqli_fetch_assoc($books)): ?>
            <div class="col-md-6 col-lg-4"><div class="card h-100 shadow-sm">
                <?php if (!empty($book['image'])): ?><img class="card-img-top" style="height:220px;object-fit:cover" src="../images/<?= rawurlencode($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>"><?php endif; ?>
                <div class="card-body d-flex flex-column"><h5><?= htmlspecialchars($book['title']) ?></h5><p class="text-muted mb-1"><?= htmlspecialchars($book['author']) ?></p><p class="small mb-2"><?= htmlspecialchars($book['genre']) ?> · <?= htmlspecialchars($book['language']) ?></p><p class="fw-bold text-success mt-auto mb-3">$<?= number_format((float) $book['price'], 2) ?></p><a class="btn btn-primary" href="book_detail.php?id=<?= (int) $book['book_id'] ?>">View details</a></div>
            </div></div>
        <?php endwhile; ?>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>
