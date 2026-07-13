<?php include("includes/header.php"); ?>

<div class="image">

	<div class="container text-center mt-5 text-white">

		<h1>
			Second-Hand Book Marketplace
		</h1>

		<p class="lead">
			Buy, Sell and Exchange Used Books
		</p>

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

	<hr class="my-5">

	<div class="row">

		<div class="col-md-4">

			<div class="card shadow-sm">

				<div class="card-body">

					<h3>📚 Buy Books</h3>

					<p>
						Find affordable second-hand books from other students.
					</p>

				</div>

			</div>

		</div>

		<div class="col-md-4">

			<div class="card shadow-sm">

				<div class="card-body">

					<h3>💰 Sell Books</h3>

					<p>
						Sell books that you no longer need and earn extra money.
					</p>

				</div>

			</div>

		</div>

		<div class="col-md-4">

			<div class="card shadow-sm">

				<div class="card-body">

					<h3>🌱 Reuse Books</h3>

					<p>
						Help reduce waste by giving books a second life.
					</p>

				</div>

			</div>

		</div>

	</div>

</div>

<?php include("includes/footer.php"); ?>
