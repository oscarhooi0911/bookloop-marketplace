<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Second-Hand Book Marketplace - Login</title>
	
	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!--CSS-->
	<link rel="stylesheet" href="css/login.css">
	
	<!--Bootstrap icons-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<div class="container-fluid vh-100">
	<div class="row h-100">
	
		<!--Left side-->
		<div class="col-lg-7 d-none d-lg-flex left-panel">
		
			<div class="overlay">
				<h1>Second-hand Book Marketplace</h1>
				<p>
					Buy. Sell. Read Again.
				</p>
			</div>
		
		</div>
		
		<!--Right side-->
		<div class="col-lg-5 d-flex align-items-center justify-content-center">
			
			<div class="login-card shadow">
				
				<h2 class="text-center mb-2">
					Welcome back
				</h2>
				
				<p class="text-center text-muted mb-4">
					Login to your account
				</p>
				
				<form action="authentication/login_process.php" method="POST">
					
					<div class="mb-3">
						<label class="form-label">
							Email Address
						</label>
						
						<input type="email" class="form-control" name="email" placeholder="Enter your email" required>
					
					</div>
					
					<div class="mb-3">
						
						<label class="form-label">
							Password
						</label>
							
						<div class="input-group">
						
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
						
							<button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
						
								<i class="bi bi-eye" id="eyeIcon"></i>
						
							</button>
						
						</div>
					
					</div>
				
					<div class="d-flex justify-content-between mb-4">
				
						<div class="form-check">
					
							<input class="form-check-input" type="checkbox" id="remember">
						
							<label class="form-check-label" for="remember">
						
								Remember me
							
							</label>
						
						</div>
					
						<a href="#">
							Forgot Password?
						</a>
					
					</div>
				
					<button type="submit" class="btn btn-login w-100">
				
						Login
					
					</button>
				</form>
			
				<hr>
			
				<p class="text-center">
			
					Don't have an account?
				
					<a href="register.php">
						Register Here
					</a>
				
				</p>
			
			</div>
		
		</div>
	
	</div>

</div>

<script>

function togglePassword(){
	
	let password=document.getElementById("password");
	let eye=document.getElementById("eyeIcon");
	
	if(password.type === "password"){
		password.type="text";
		eye.className="bi bi-eye-slash";	
	} else{
		password.type="password";
		eye.className="bi bi-eye";	
	}
}

</script>

</body>

</html>