<?php
include '../config/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: books.php");
        exit();
    } else {
        echo "<p style='color:red;'>Invalid email or password.</p>";
    }
}
?>

<h2>Buyer Login</h2>
<br>
<form action="login.php" method="POST" style="max-width: 400px; background: white; padding: 20px; border-radius: 8px;">
    <p>
		<label>Email:</label><br>
		<input type="email" name="email" required style="width: 100%; padding: 8px;">
	</p> <br>
	
    <p>
		<label>Password:</label><br>
		<input type="password" name="password" required style="width: 100%; padding: 8px;">
	</p> <br>
	
    <button type="submit" class="btn">Login</button>
</form>

</body>
</html>