<?php include("includes/header.php"); ?>

<div class="image">

	<div class="container d-flex align-items-center">

		<div class="text-start text-white">
			<h1>
				Second-Hand Book Marketplace
			</h1>

			<p class="lead mb-4">
				Discover affordable second-hand books from readers.
				buy books you love, sell books you no longer need,
				and give every book a new journey.
			</p>
		
			
			<!--Check user or staff or not login-->
			<?php
			if(isset($_SESSION['user_id'])){

				if($_SESSION['role']=="staff"){
					echo '<a href="staff/dashboard.php" class="btn btn-primary btn-lg">
							Go to Dashboard
						</a>';
				}else{
					echo '<a href="customer/dashboard.php" class="btn btn-primary btn-lg">
							Go to Dashboard
						</a>';
				}

			}else{
			?>
				<a href="login.php" class="btn btn-primary btn-lg">
					Get Started
				</a>
			<?php
			}
			?>
			
		</div>

	</div>
	
</div>

<!--Buy Books-->

<div class="container py-3">

	<div class="row align-items-center feature-box shadow">

		<div class="col-md-6">

			<h3>📚 Buy Books</h3>

			<p class="lead">
				Find affordable second-hand books from other readers.
				Explore a wide range of books and discover your next favourite read.
			</p>

		</div>
		
		<div class="col-md-6 text-center">
		
			<img src="image/buy-books.jpg" class="img-fluid rounded shadow feature-img">
			
		</div>
		
	</div>
	
</div>

<!--Sell books-->
<div class="container py-3">

	<div class="row align-items-center feature-box shadow">

		<div class="col-md-6 text-center">
			
			<img src="image/sell-books.jpg" class="img-fluid rounded shadow feature-img">
		
		</div>

		<div class="col-md-6">
		
			<h3>💰 Sell Books</h3>

			<p class="lead">
				Sell books that you no longer need to earn etxra money.
			</p>
			
		</div>

	</div>
	
</div>

<!--Reuse Books-->

<div class="container py-3">

	<div class="row align-items-center feature-box shadow">

		<div class="col-md-6">

			<h3>🌱 Reuse Books</h3>

			<p class="lead">
				Give books a second life and reduce waste by sharing knowledge with others.
			</p>

		</div>
		
		<div class="col-md-6 text-center">
		
			<img src="image/reuse-books.jpg" class="img-fluid rounded shadow feature-img">
			
		</div>
		
	</div>
	
</div>

<?php include("includes/footer.php"); ?>
