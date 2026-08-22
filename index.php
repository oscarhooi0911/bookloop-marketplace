<?php 
include("includes/header.php"); 
?>

<link rel="stylesheet" href="css/style.css">

<!-- Hero Section -->
<div class="image">
	<div class="hero-container">
		<div class="hero-content">
			<span class="hero-eyebrow">Sustainable stories, shared again</span>
			
			<h1>Second-Hand Book Marketplace</h1>
			
			<p class="hero-description">
				Discover affordable second-hand books from readers.
				Buy books you love, sell books you no longer need,
				and give every book a new journey.
			</p>
			
			<?php
			if (isset($_SESSION['user_id'])) {
				if ($_SESSION['role'] == "staff") {
					echo '
						<a href="staff/dashboard.php" class="custom-btn">
							Go to Dashboard
						</a>
					';
				} else {
					echo '
						<a href="customer/dashboard.php" class="custom-btn">
							Go to Dashboard
						</a>
					';
				}
			} else {
			?>
				<a href="login.php" class="custom-btn">Get Started</a>
			<?php
			}
			?>
		</div>
	</div>
</div>

<!-- Buy Books -->
<div class="feature-row">
	<div class="feature-box">
		<div class="feature-content">
			<h3>📚 Buy Books</h3>
			<p>
				Find affordable second-hand books from other readers.
				Explore a wide range of books and discover your next
				favourite read.
			</p>
		</div>

		<div class="feature-image-container">
			<img src="images/buy-books.jpg" class="feature-img" alt="Buy second-hand books">
		</div>
	</div>
</div>

<!-- Sell Books -->
<div class="feature-row feature-row-right">
	<div class="feature-box">
		<div class="feature-image-container">
			<img src="images/sell-books.jpg" class="feature-img" alt="Sell second-hand books">
		</div>

		<div class="feature-content">
			<h3>💰 Sell Books</h3>
			<p>Sell books that you no longer need to earn extra money.</p>
		</div>
	</div>
</div>

<!-- Reuse Books -->
<div class="feature-row">
	<div class="feature-box">
		<div class="feature-content">
			<h3>🌱 Reuse Books</h3>
			<p>
				Give books a second life and reduce waste by sharing
				knowledge with others.
			</p>
		</div>
		<div class="feature-image-container">
			<img src="images/reuse-books.jpg" class="feature-img" alt="Reuse second-hand books">
		</div>
	</div>
</div>

<?php 
include("includes/footer.php"); 
?>