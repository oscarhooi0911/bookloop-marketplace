<?php
include("../authentication/check_login.php");
include("../includes/header.php");
?>



<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">

	<div class="card shadow p-4" style="width:450px; border-radius:15px;">
	
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
			
			<!--handling error-->
			<?php
			if(isset($_GET['error'])){
				
				if($_GET['error'] == "wrongcurrent"){
					echo '<div class="text-danger small	text-center mb-3">
							Incorrect current password.
							</div>';
				}
				
				if($_GET['error'] == "nomatch"){
					echo '<div class="text-danger small text-center mb-3">
							New password and confirm password do not match
							</div>';
				}
				
				if($_GET['error'] == "usernotfound"){
					echo '<div class="text-danger small text-center mb-3">
							User not found.
							</div>';
				}
				
				if($_GET['error'] == "weakpassword"){
					echo '<div class="text-danger small text-center mb-3">
									<ul>
										<li>At least 8 characters</li>
										<li>At least 1 uppercase letter (A-Z)</li>
										<li>At least 1 number (0-9)</li>
										<li>At least 1 special character (@, #, $, !)</li>
									</ul>
							</div>';
				}
				
			}
			
			if(isset($_GET['success'])){
					echo '<div class="text-success small text-center mb-3">
							Password updated successfully.
							</div>';
			}
			
			?>
		
			<div class="d-grid">
				
				<button type="submit" class="btn btn-primary">
			
					Update Password
			
				</button>
			
			</div>
			
			<div class="text-center mt-3">
				
				<a href="profile.php" class="btn btn-outline-secondary">
					Back to profile
				</a>
				
			</div>
			
		</form>
		
	</div>

</div>

<?php include("../includes/footer.php"); ?>


