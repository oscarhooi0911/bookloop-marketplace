<?php

include("database/database.php");

$email = $_POST['email'];

$stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email=?");

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);


if(!$user){

	header("Location: forgot_password.php?error=emailnotfound");
	exit();

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

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
					Create a new password and continue your book journey.
				</p>

			</div>

		</div>

		<!-- Right Side -->
		<div class="col-lg-5 d-flex align-items-center justify-content-center">


			<div class="login-card shadow">


				<h2 class="text-center mb-3">

					Reset Password

				</h2>

				<p class="text-center text-muted mb-4">

					Enter your new password below.

				</p>

				<form action="update_reset_password.php" method="POST">


					<input type="hidden" 
					name="user_id" 
					value="<?php echo $user['user_id']; ?>">



					<div class="mb-3">


						<label class="form-label">
							New Password
						</label>


						<input 
						type="password"
						name="password"
						class="form-control"
						placeholder="Enter new password"
						required>


					</div>

					<div class="mb-3">


						<label class="form-label">
							Confirm Password
						</label>


						<input 
						type="password"
						name="confirm_password"
						class="form-control"
						placeholder="Confirm new password"
						required>


					</div>

					<?php

					if(isset($_GET['error'])){

						if($_GET['error']=="nomatch"){

							echo '
							<div class="text-danger small text-center mb-3">
							Password and confirm password do not match.
							</div>';

						}

						if($_GET['error']=="weakpassword"){

							echo '
							<div class="text-danger small text-center mb-3">
							Password must contain:
							<br>At least 8 characters
							<br>One uppercase letter
							<br>One number
							<br>One special character (@ # $ !)
							</div>';

						}


					}


					?>

					<button 
					type="submit"
					class="btn btn-login w-100">

						Update Password

					</button>



				</form>

				<hr>

				<p class="text-center">

					Remember your password?

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