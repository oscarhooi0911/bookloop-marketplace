<?php
include("../authentication/check_login.php");
include("../includes/header.php");
?>



<div class="container d-flex justify-content-center align-items-center" style=min-height: 80vh;">

	<div class="card shadow p-4" style="width:450px; corder-radius:15px;">
	
		<h2 class="text-center mb-4">
			Change Password
		</h2>

		<form action="update_password.php" method="POST">
			
			<div class="mb-3">
			
				<label>Current Password</label>
				<input type="password" name="current_password" class="form-control" required>
				
			</div>
			
			<div class="mb-3">
				
				<label>New Password</label>
				<input type="password" name="new_password" class="form-control" required>
			
			</div>
			
			<div class="mb-3">
			
				<label>Confirm New Password</label>
				
				<input type="password" name="confirm_password" class="form-control" required>
			
			</div>
			
			<div class="d-grid">
				
				<button type="submit" class="btn btn-primary">
			
					Update Password
			
				</button>
			
			</div>
			
			<div class="text-venter mt-3">
				
				<a href="profile.php" class="btn btn-outline-secondary">
					Back to profile
				</a>
				
			</div>
			
		</form>
		
	</div>

</div>

<?php include("../includes/footer.php"); ?>


