<?php
if(session_status() == PHP_SESSION_NONE){
	session_start();
}
?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Second-Hand Book Marketplace</title>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="/bookloop-marketplace/css/style.css">
	
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	
	<div class="container">
	
		<a class="navbar-brand" href="/bookloop-marketplace/index.php">
			Bookloop Marketpalce
		</a>
		
		<div class="ms-auto">
		
			<?php
			
			if(isset($_SESSION['user_id'])){
				
				if($_SESSION['role'] == "staff"){
					
					echo '<a href="/bookloop-marketplace/staff/dashboard.php"
					class="btn btn-warning me-2">
					dashboard
					</a>';
				} else{
					echo '<a href="/bookloop-marketplace/customer/dashboard.php"
					class="btn btn-success me-2">
					dashboard
					</a>';
				}
				
				echo '<a href="/bookloop-marketplace/logout.php"
				class="btn btn-danger">
				logout
				</a>';
			} else{
				echo '<a href="/bookloop-marketplace/login.php"
				class="btn btn-outline-light me-2">
				Login
				</a>
				
				<a href="/bookloop-marketplace/register.php"
				class="btn btn-success">
				Register
				</a>';
			}
			
			?>
			
		</div>
		
	</div>
	
</nav>