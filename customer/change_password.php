<?php
include("../authentication/check_login.php");
?>

<!DOCTYPE html>

<html>

<head>

<title>Change Password</title>

<link href="https://csn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

	<h2>Change Password</h2>

	<form action="update_password.php" method="POST">
		
		<div class="mb-3">
		
			<label>Current Password</label>
			<input type="password" name="current_password" class="form-control" required>
			
		</div>
		
		<div class="mb-3">
		
			<label>Confirm New Password</label>
			
			<input type="password" name="confirm_password" class="form-control" required>
		
		</div>
		
		<button class="btn btn-primary">
		
		Update Password
		
		</button>
		
	</form>

</div>

</body>

</html>
