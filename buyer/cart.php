<?php
include '../config/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Please <a href='login.php'>login</a> to manage your cart.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $book_id = intval($_POST['book_id']);
        $qty = intval($_POST['quantity']);
        
        $check = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND book_id = ?");
        $check->bind_param("ii", $user_id, $book_id);
        $check->execute();
        $res = $check->get_result()->fetch_assoc();
        
        if ($res) {
            $new_qty = $res['quantity'] + $qty;
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
            $update->bind_param("ii", $new_qty, $res['cart_id']);
            $update->execute();
        } else {
            $insert = $conn->prepare("INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?)");
            $insert->bind_param("iii", $user_id, $book_id, $qty);
            $insert->execute();
        }
    } elseif ($action === 'delete') {
        $cart_id = intval($_POST['cart_id']);
        $delete = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
        $delete->bind_param("ii", $cart_id, $user_id);
        $delete->execute();
    }
}

$sql = "SELECT c.cart_id, c.quantity, b.title, b.price FROM cart c JOIN books b ON c.book_id = b.book_id WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();
?>

<h2>Your Shopping Cart</h2>
<br>

<?php if ($cart_items->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; background: white; border-collapse: collapse;">
        <tr>
            <th>Book Title</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php 
			$grand_total = 0;
			while ($item = $cart_items->fetch_assoc()): 
				$subtotal = $item['price'] * $item['quantity'];
				$grand_total += $subtotal;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($item['title']); ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($subtotal, 2); ?></td>
                <td>
                    <form action="cart.php" method="POST" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                        <input type="hidden" name="action" value="delete">
						
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="3" align="right"><strong>Grand Total:</strong></td>
            <td colspan="2"><strong>$<?php echo number_format($grand_total, 2); ?></strong></td>
        </tr>
    </table>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

</body>
</html>