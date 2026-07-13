<?php
include("../authentication/check_login.php");
include("../database/database.php");
include("../includes/header.php");

$id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
	
	<div class="card shadow p-4" style="width: 500px; border-radius: 15px;">
	
		<h2 class="text-center mb-4">
		
			Edit Profile
		</h2>

		<form action="update_profile.php" method="POST" enctype="multipart/form-data">
			
			<div class="mb-3">
			
				<label>Full Name</label>
				<input  type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
			
			</div>
			
			<div class="mb-3">
			
				<label>Email</label>
			
				<input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
			
			</div>
			
			<div class="mb-3">
			
				<label>Phone</label>
				
				<input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
				
			</div>
			
			<div class="mb-3">
			
				<label>Address</label>
			
				<textarea name="address" class="form-control" rows="4"><?php echo htmlspecialchars($user['address']); ?></textarea>
				
			</div>
			
			<div class="mb-3">
			
				<label>Profile Picture</label>
				
				<input type="file" name="profile_picture" class="form-control" accept=".jpg, .jpeg, .png">
			
			</div>
			
			<div class="d-grid mb-2">
			
				<button type="submit" class="btn btn-primary">
					Save Changes
				</button>
				
			</div>
			
			<div class="d-grid">
			
				<a href="profile.php" class="btn btn-outline-secondary">
					Cancel
				</a>
				
			</div>

		</form>
		
	</div>

</div>

<?php include("../includes/footer.php"); ?>