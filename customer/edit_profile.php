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


/* Error messages */
$full_name_error = $_GET['full_name_error'] ?? '';
$phone_error = $_GET['phone_error'] ?? '';
$address_error = $_GET['address_error'] ?? '';
$profile_picture_error = $_GET['profile_picture_error'] ?? '';

?>

<div class="edit-profile-container">
	
	<div class="edit-profile-card">
	
		<h2>Edit Profile</h2>
		
		<form action="update_profile.php" method="POST" enctype="multipart/form-data">
		
			<div class="edit-form-group">
				<label>Full Name</label>
				<input
					type="text"
					name="full_name"
					value="<?php echo htmlspecialchars($user['full_name']); ?>"
					required
				>
				
				<!--error-->
				<?php if ($full_name_error !== ''): ?>
					<div class="error-message">
						<?php echo htmlspecialchars($full_name_error); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="edit-form-group">
				<label>Email</label>
				<input
					type="email"
					value="<?php echo htmlspecialchars($user['email']); ?>"
					readonly
				>
			</div>
			
			<div class="edit-form-group">
				<label>Phone</label>
				<input
					type="text"
					name="phone"
					value="<?php echo htmlspecialchars($user['phone']); ?>"
				>

				<?php if ($phone_error !== ''): ?>
					<div class="error-message">
						<?php echo htmlspecialchars($phone_error); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="edit-form-group">
				<label>Address</label>
				<textarea
					name="address"
					rows="4"
				><?php echo htmlspecialchars($user['address']); ?></textarea>
				
				<?php if ($address_error !== ''): ?>
					<div class="error-message">
						<?php echo htmlspecialchars($address_error); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="edit-form-group">
				<label>Profile Picture</label>
				<input
					type="file"
					name="profile_picture"
					accept=".jpg, .jpeg, .png"
				>
				
				<?php if ($phone_error !== ''): ?>
					<div class="error-message">
						<?php echo htmlspecialchars($profile_picture_error); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="edit-submit">
				<button type="submit">Save Changes</button>
			</div>
			
			<div class="edit-cancel">
				<a href="profile.php">Cancel</a>
			</div>
			
		</form>
		
	</div>
	
</div>

<?php
include("../includes/footer.php");
?>