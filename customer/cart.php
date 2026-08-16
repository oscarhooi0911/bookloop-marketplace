<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

if ($_SESSION['role'] !== 'customer') {
    header('Location: ../staff/dashboard.php');
    exit();
}

$userId = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    // Add to an existing cart line when the same book is selected again.
    if ($action === 'add') {
        $bookId = (int) ($_POST['book_id'] ?? 0);
        $quantity = max(1, min(10, (int) ($_POST['quantity'] ?? 1)));
        $book = mysqli_prepare($conn, 'SELECT book_id FROM books WHERE book_id = ?');
        mysqli_stmt_bind_param($book, 'i', $bookId);
        mysqli_stmt_execute($book);
        if (mysqli_stmt_get_result($book)->fetch_assoc()) {
            $add = mysqli_prepare($conn, 'INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = LEAST(quantity + VALUES(quantity), 10)');
            mysqli_stmt_bind_param($add, 'iii', $userId, $bookId, $quantity);
            mysqli_stmt_execute($add);
        }
    } elseif ($action === 'remove') {
        $cartId = (int) ($_POST['cart_id'] ?? 0);
        $remove = mysqli_prepare($conn, 'DELETE FROM cart WHERE cart_id = ? AND user_id = ?');
        mysqli_stmt_bind_param($remove, 'ii', $cartId, $userId);
        mysqli_stmt_execute($remove);
    }
    header('Location: cart.php');
    exit();
}

$stmt = mysqli_prepare($conn, 'SELECT c.cart_id, c.quantity, b.title, b.price FROM cart c INNER JOIN books b ON b.book_id = c.book_id WHERE c.user_id = ? ORDER BY c.cart_id DESC');
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
$items = mysqli_stmt_get_result($stmt);
require_once "../includes/header.php";
?>
<div class="container py-5"><div class="d-flex justify-content-between align-items-center mb-4"><h2 class="mb-0">Your cart</h2><a class="btn btn-outline-primary" href="browse_books.php">Continue browsing</a></div>
<?php if (mysqli_num_rows($items) === 0): ?><div class="alert alert-info">Your cart is empty.</div><?php else: $total = 0; ?><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Book</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr></thead><tbody><?php while ($item = mysqli_fetch_assoc($items)): $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?><tr><td><?= htmlspecialchars($item['title']) ?></td><td>$<?= number_format((float) $item['price'], 2) ?></td><td><?= (int) $item['quantity'] ?></td><td>$<?= number_format($subtotal, 2) ?></td><td><form method="post"><input type="hidden" name="action" value="remove"><input type="hidden" name="cart_id" value="<?= (int) $item['cart_id'] ?>"><button class="btn btn-sm btn-danger">Remove</button></form></td></tr><?php endwhile; ?></tbody><tfoot><tr><th colspan="3" class="text-end">Grand total</th><th>$<?= number_format($total, 2) ?></th><th></th></tr></tfoot></table></div><?php endif; ?></div>
<?php require_once "../includes/footer.php"; ?>
