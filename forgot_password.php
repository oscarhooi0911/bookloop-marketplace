<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Forgot Password</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="css/login.css">

</head>

<body>

<div class="container-fluid vh-100">

	<div class="row h-100">
	
		<!--Left Side-->
		<div class="col-lg-7 d-none d-lg-flex left-panel">
		
			<div class="overlay">
			
				<h1>
					Second-Hand Book Marketplace
				</h1>
				
				<p>
					Reset your password and continue your book journey.
				</p>
				
			</div>
			
		</div>
		
		<!--Right side-->
		<div class="col-lg-5 d-flex align-items-center justify-content-center">
		
			<div class="login-card shadow">
			
				<h2 class="text-center mb-3">
					Forgot Password
				</h2>
				
				<p class="text-center text-muted mb-4">
					Enter your email to reset your password.
				</p>
				
				
				<form action="reset_password.php" method="POST">
					
					<div class="mb-3">
					
						<label class="label-form">
							Email Address
						</label>
						
						<input type="email" name="email" class="form=control" placeholder="Enter your email" required>
						
					</div>
					
					<?php
					
					if(isset($_GET['error'])){
						
						if($_GET['error'] == "emailnotfound"){
							
							echo '<div class="text-danger small text-center mb-3">
									Email does not exist.
									</div>';
						}
						
					}
					
					?>
					
					
					<button type="submit" class="btn btn-login w-100">
						continue
					</button>
					
				</form>
				
				<hr>
				
				<p class="text-center">
					Remember your password?
					
					<a href="login.php">
						Login here.
					</a>
				
				</p>
				
			</div>
			
		</div>
		
	</div>
	
</div>

</body>

</html>