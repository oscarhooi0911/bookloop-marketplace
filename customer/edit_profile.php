<?php
include("../authentication/check_login.php");
include("../authentication/database.php");

$id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet:>

</head>

<body>

<div class="container mt-5">

<h2>Edit Profile</h2>

<form action="update_profile.php" method="POST" enctype="multipart/form-data">
	
	<div class="mb-3">
	
		<label>Full Name</label>
		<input  type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
	
	</div>
	
	<div class="mb-3">
	
		<label>Email</label>
	
		<input type="email" class="form-control" calue=<?php echo htmlspecialchard($user['email']); ?>" readonly>
	
	</div>
	
	<div class="mb-3">
	
		<label>Phone</label>
		
		<input type="text" name="phone" class="form-control" calue"<?php echo htmlspecialchars($user['phone']); ?>">
		
	</div>
	
	<div class="mb-3">
	
		<label>Address</label>
	
		<textarea name="address" class="form-control" rows="4"><?php echo htmlspecialchars($user['address']); ?></textarea>
		
	</div>
	
	<div class="mb-3">
	
		<label>Profile Picture</label>
		
		<input type="file" name="profile_picture" class="form-control" accept=".jpg, .jpeg, .png">
	
	</div>
	
	<button class="btn btn-primary">
		Save Changes
	</button>
	
	<a href="profile.php" class="btn btn-secondary">
		Cancel
	</a>

</form>

</body>

</html>