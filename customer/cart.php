<?php
require_once "../authentication/check_login.php";
require_once "../database/database.php";

if ($_SESSION['role'] !== 'customer') {
    header('Location: ../staff/dashboard.php');
    exit();
}

$userId = (int) $_SESSION['user_id'];


/* =========================================================
   CART ACTIONS
   ========================================================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';


    /* Add book to cart */

    if ($action === 'add') {

        $bookId = (int) ($_POST['book_id'] ?? 0);

        $quantity = max(
            1,
            min(10, (int) ($_POST['quantity'] ?? 1))
        );


        $book = mysqli_prepare(
            $conn,
            'SELECT book_id FROM books WHERE book_id = ?'
        );

        mysqli_stmt_bind_param(
            $book,
            'i',
            $bookId
        );

        mysqli_stmt_execute($book);


        if (mysqli_stmt_get_result($book)->fetch_assoc()) {

            $add = mysqli_prepare(
                $conn,
                'INSERT INTO cart (user_id, book_id, quantity)
                 VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                 quantity = LEAST(quantity + VALUES(quantity), 10)'
            );

            mysqli_stmt_bind_param(
                $add,
                'iii',
                $userId,
                $bookId,
                $quantity
            );

            mysqli_stmt_execute($add);
        }
    }


    /* Remove book from cart */

    elseif ($action === 'remove') {

        $cartId = (int) ($_POST['cart_id'] ?? 0);

        $remove = mysqli_prepare(
            $conn,
            'DELETE FROM cart
             WHERE cart_id = ?
             AND user_id = ?'
        );

        mysqli_stmt_bind_param(
            $remove,
            'ii',
            $cartId,
            $userId
        );

        mysqli_stmt_execute($remove);
    }


    header('Location: cart.php');
    exit();
}


/* =========================================================
   GET CART ITEMS
   ========================================================= */

$stmt = mysqli_prepare(
    $conn,
    'SELECT
        c.cart_id,
        c.quantity,
        b.title,
        b.price
     FROM cart c
     INNER JOIN books b
        ON b.book_id = c.book_id
     WHERE c.user_id = ?
     ORDER BY c.cart_id DESC'
);

mysqli_stmt_bind_param(
    $stmt,
    'i',
    $userId
);

mysqli_stmt_execute($stmt);

$items = mysqli_stmt_get_result($stmt);


require_once "../includes/header.php";
?>


<div class="container cart-container">

    <!-- Cart Header -->
    <div class="cart-header">
        <div>
            <h2>Your Cart</h2>
            <p class="cart-subtitle">Review the books you have selected.</p>
        </div>
        <a class="cart-button cart-button-primary" href="browse_books.php">Continue Browsing</a>
    </div>

    <?php if (mysqli_num_rows($items) === 0): ?>
        <!-- Empty Cart -->
        <div class="cart-empty">
            Your cart is empty.
            <a href="browse_books.php">Browse Books</a>
        </div>

    <?php else: ?>
        <?php $total = 0; ?>
        <!-- Cart Table -->
        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($items)): ?>
                        <?php
                        $subtotal =
                            $item['price'] *
                            $item['quantity'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($item['title']) ?></td>
                            <td>RM<?= number_format((float) $item['price'],2) ?></td>
                            <td><?= (int) $item['quantity'] ?></td>
                            <td>RM<?= number_format($subtotal,2) ?></td>
                            <td>
                                <form method="post" class="cart-remove-form">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="cart_id" value="<?= (int) $item['cart_id'] ?>">
                                    <button type="submit" class="cart-button cart-button-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="cart-total-label">Grand Total</th>
                        <th>RM<?= number_format($total,2) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
require_once "../includes/footer.php";
?>