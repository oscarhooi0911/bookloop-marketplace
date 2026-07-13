<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Second-Hand Book Marketplace - Register</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS -->
<link rel="stylesheet" href="css/login.css">

</head>


<body>


<div class="container-fluid vh-100">

	<div class="row h-100">


		<!-- Left Side -->

		<div class="col-lg-7 d-none d-lg-flex left-panel">

			<div class="overlay">

				<h1>
					Second-Hand Book Marketplace
				</h1>

				<p>
					Buy. Sell. Read Again.
				</p>

			</div>

		</div>



		<!-- Right Side -->

		<div class="col-lg-5 d-flex align-items-center justify-content-center">


			<div class="login-card shadow">


				<h2 class="text-center mb-2">
					Create Account
				</h2>


				<p class="text-center text-muted mb-4">
					Register to start buying and selling books
				</p>



				<form action="authentication/register_process.php" method="POST">


					<div class="mb-3">

						<label class="form-label">
							Full Name
						</label>


						<input 
						type="text"
						class="form-control"
						name="full_name"
						placeholder="Enter your full name"
						required>

					</div>



					<div class="mb-3">

						<label class="form-label">
							Email Address
						</label>


						<input 
						type="email"
						class="form-control"
						name="email"
						placeholder="Enter your email"
						required>

					</div>




					<div class="mb-3">

						<label class="form-label">
							Phone Number
						</label>


						<input 
						type="text"
						class="form-control"
						name="phone"
						placeholder="Enter your phone number">

					</div>




					<div class="mb-3">

						<label class="form-label">
							Address
						</label>


						<textarea
						class="form-control"
						name="address"
						rows="2"
						placeholder="Enter your address"></textarea>


					</div>

					<div class="mb-3">

						<label class="form-label">
							Password
						</label>


						<input 
						type="password"
						class="form-control"
						name="password"
						placeholder="Create password"
						required>

					</div>


					<div class="mb-3">

						<label class="form-label">
							Confirm Password
						</label>


						<input 
						type="password"
						class="form-control"
						name="confirm_password"
						placeholder="Confirm password"
						required>

					</div>
					
					<?php
					if(isset($_GET['error'])){
						if($_GET['error'] == "email_exists"){
							echo '<div class="text-danger small text-center mb-3">
									Email already exists. Please use another email.
									</div>';
						}
						
					}
					?>

					<button 
					type="submit"
					class="btn btn-login w-100">

						Register

					</button>



				</form>



				<hr>



				<p class="text-center">

					Already have an account?

					<a href="login.php">
						Login Here
					</a>

				</p>


			</div>

		</div>

	</div>

</div>

</body>

</html>