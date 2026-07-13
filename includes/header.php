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

	<main>
	
		<div class="container">
		
			<a class="navbar-brand" href="/bookloop-marketplace/index.php">
				Bookloop Marketpalce
			</a>
			
			<button class="navbar-toggler" type="button"
					data-bs-toggle="collapse"
					data-bs-target="#navbarNav">
					
					<span class="navbar-toggler-icon"></span>
					
			</button>
			
			<div class="collapse navbar-collapse" id="navbarNav">
				
				<?php if(isset($_SESSION['user_id'])){ ?>
				
					<?php if($_SESSION['role'] == "customer"){ ?>
				
						<ul class="navbar-nav ms-auto align-items-center">
						
							<li class="nav-item">
							
								<a class="nav-link" href="/bookloop-marketplace/index.php">
									Home
								</a>
								
							</li>
							
							<li class="nav-item">
							
								<!--replaace with correct php-->
								<a class="nav-link" href="/bookloop-marketplace/customer/buy_book.php">
									Buy
								</a>
								
							</li>
							
							<li class="nav-item">
							
								<!--replaace with correct php-->
								<a class="nav-link" href="/bookloop-marketplace/customer/sell_book.php">
									Sell
								</a>
								
							</li>
							
							<li class="nav-item">
							
								<!--replaace with correct php-->
								<a class="nav-link" href="/bookloop-marketplace/customer/profile.php">
									Profile
								</a>
								
							</li>
							
							<li class="nav-item ms-2">
							
								<a class="btn btn-danger" href="/bookloop-marketplace/logout.php">
									logout
								</a>
								
							</li>
								
						</ul>
					
					<?php } else{ ?>
					
						<ul class="navbar-nav ms auto align-items-center">
						
							<li class="nav-item">
								
								<a class="nav-link" href="/bookloop-marketplace/staff/dashboard.php">
									Dashboard
								</a>
								
							</li>
							
							<li class="nav-item ms-2">
								
								<a class="btn btn-danger" href="/bookloop-marketplace/logout.php">
									Logout
								</a>
								
							</li>
							
						</ul>
					
					<?php } ?>
				
			<?php } else { ?>
			
				<div class="ms-auto">
				
					<a href="/bookloop-marketplace/login.php"
						class="btn btn-outline-light me-2">
						Login
					</a>
					
					<a href="/bookloop-marketplace/register.php"
						class="btn btn-success">
						Register
					</a>
				
				</div>
				
			<?php } ?>	
			
		
				
				
			</div>
			
		</div>
		
	
</nav>