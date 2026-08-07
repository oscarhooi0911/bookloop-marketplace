<?php
include '../config/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Registration successful! <a href='login.php'>Login here</a>.</p>";
    } else {
        echo "<p style='color:red;'>Error: Email already registered.</p>";
    }
}
?>

<h2>Buyer Registration</h2>
<br>
<form action="register.php" method="POST" style="max-width: 400px; background: white; padding: 20px; border-radius: 8px;">
    <p>
		<label>Full Name:</label> <br>
		<input type="text" name="name" required style="width: 100%; padding: 8px;">
	</p> <br>
	
    <p>
		<label>Email:</label> <br>
		<input type="email" name="email" required style="width: 100%; padding: 8px;">
	</p> <br>
	
    <p>
		<label>Password:</label> <br>
		<input type="password" name="password" required style="width: 100%; padding: 8px;">
	</p> <br>
    
	<button type="submit" class="btn">Register</button>
</form>

</body>
</html>