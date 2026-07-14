<!--Staff Dashboard-->
<?php
include("../authentication/check_staff.php");
include("../includes/header.php");
?>

<div class="container py-5">
	
	<div class="card shadow corder-0 mb-4">
		
		<div class="card-body">
		
			<div class="d-flex align-items-center">
			
				<img src="../upload/profile/<?php echo $_SESSION['profile_picture']; ?>"
					width="90" height="90" class="rounded-circle border me-4">
					
					
				<div>
				
					<h2 class="mb-1">
						
						Welcome,
						<?php echo $_SESSION['name']; ?>
					
					</h2>
					
					<p class="text-muted mb-0">
						
						Staff Dashboard
					
					</p>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="row g-4">
		
		<div class="col-md-3">
		
			<div class="card shadow h-100">
			
				<div class="card-body text-center">
				
					<h3>👥</h3>
					
					<h5 class="mt-3">
						Manage users
					</h5>
					
					<p class="text-muted">
						View and manage customer accounts.
					</p>
					
					<!--Replace with correct php name-->
					<a href="manage_users.php" class="btn btn-primary">
						open
					</a>
					
				</div>
				
			</div>
			
		</div>
		
		<div class="col-md-3">
		
			<div class="card shadow h-100">
			
				<div class="card-body text-center">
				
					<h3>📚</h3>
					
					<h5 class="mt-3">
						Manage Books.
					</h5>
					
					<p class="text-muted">
						Approve and manage book listings.
					</p>
					
					<!--Replace with correct pgp name-->
					<a href="manage_books.php" class="btn btn-success">
						open
					</a>
					
				</div>
				
			</div>
			
		</div>
		
		<div class="col-md-3">
		
			<div class="card shadow h-100">
			
				<div class="card-body text-center">
				
					<h3>🛒</h3>
					
					<h5 class="mt-3">
						Manage Orders
					</h5>
					
					<p class="text-muted">
						View customer orders.
					</p>
					
					<!--Replace with correct php name-->
					<a href="manage_orders.php" class="btn btn-warning">
						open
					</a>
					
				</div>
				
			</div>
			
		</div>
		
		<div class="col-md-3">
		
			<div class="card shadow h-100">
			
				<div class="card-body text-center">
				
					<h3>📊</h3>
					
					<h5 class="mt-3">
						Reports
					</h5>
					
					<p class="text-muted">
						Generate sales and user reports.
					</p>
					
					<!--Replace with correct php name-->
					<a href="reports.php" class="btn btn-info">
						open
					</a>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</div>


<?php include("../includes/footer.php"); ?>