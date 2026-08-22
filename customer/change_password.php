<?php
include("../authentication/check_login.php");
include("../includes/header.php");
?>

<div class="change-password-container">
	<div class="change-password-card">
		<h2>Change Password</h2>
		
		<form action="update_password.php" method="POST">
		
			<div class="password-form-group">
				<label>Current Password</label>
				<input 
					type="password" 
					name="current_password" 
					required
				>
			</div>
			
			<div class="password-form-group">
				<label>New Password</label>
				<input 
					type="password" 
					name="new_password" 
					required
				>
			</div>
			
			<div class="password-form-group">
				<label>Confirm New Password</label>
				<input 
					type="password" 
					name="confirm_password" 
					required
				>
			</div>
			
			<!-- Handling error -->
			<?php
				if(isset($_GET['error'])){
					if($_GET['error'] == "wrongcurrent"){
						echo '<div class="password-error">Incorrect current password.</div>';
					}
					
					if($_GET['error'] == "nomatch"){
						echo '<div class="password-error">New password and confirm password do not match.</div>';
					}
					
					if($_GET['error'] == "usernotfound"){
						echo '<div class="password-error">User not found.</div>';
					}
					
					if($_GET['error'] == "weakpassword"){
						echo '
						<div class="password-error password-error-list">
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
					echo '
					<div class="password-success">Password updated successfully.</div>';
				}
			?>
		
			<div class="password-submit">
				<button type="submit">Update Password</button>
			</div>
			
			<div class="password-back">
				<a href="profile.php">Back to profile</a>
			</div>
		</form>
	</div>
</div>

<?php
include("../includes/footer.php");
?>