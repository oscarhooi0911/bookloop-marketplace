<?php
include("../authentication/check_login.php");
include("../database/database.php");

if ($_SESSION['role'] != "customer") {
    header("Location: ../staff/dashboard.php");
    exit();
}

$id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Check if user exists
if (!$user) {
    // User not found - log out or redirect
    session_destroy();
    header("Location: ../login.php?error=user_not_found");
    exit();
}

include("../includes/header.php");
?>

<div class="customer-dashboard">

	<!-- Profile Section -->
	<div class="dashboard-profile">
		<div class="dashboard-profile-body">
			<div class="dashboard-profile-info">
				<?php $profile_pic = !empty($user['profile_picture']) ? $user['profile_picture'] : 'default.png';?>
				<img
					src="../upload/profile/<?php echo htmlspecialchars($profile_pic); ?>"
					width="120"
					height="120"
					class="profile-picture"
					alt="Profile Picture"
				>

				<div>
					<h2><?php echo htmlspecialchars($user['full_name']); ?></h2>
					<p class="profile-role">Customer Account</p>
					<div class="dashboard-buttons">
						<a href="profile.php" class="dashboard-button dashboard-button-primary">View Profile</a>
						<a href="edit_profile.php" class="dashboard-button dashboard-button-secondary">Edit Profile</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Navigation -->
	<div class="card shadow-sm border-0 mb-4">
	<div class="dashboard-navigation">

		<div class="dashboard-navigation-body">
			<ul class="dashboard-nav">
				<li><a class="active" href="#">Home</a></li>
				<li class="nav-item"><a class="nav-link" href="../seller/my_books.php">My Books</a></li>
				<li><a href="wishlist.php">Wishlist</a></li>
			</ul>
		</div>
	</div>

	<!-- Dashboard Cards -->
	<div class="dashboard-cards">
		<div class="dashboard-card">
			<div class="dashboard-card-body">
				<h1>📚</h1>
				<h5>My Books</h5>
				<p>Manage your books for sale.</p>
		
				<button class="card-button">
					<a href="../seller/my_books.php">Manage Book</a>
				</button>
			</div>
		</div>

		<div class="dashboard-card">
			<div class="dashboard-card-body">
				<h1>❤️</h1>
				<h5>Wishlist</h5>
				<p>View your favourite books.</p>
				
				<button class="card-button">
					<a href="wishlist.php">View Wishlist</a>
				</button>
			</div>
		</div>

		<div class="dashboard-card">
			<div class="dashboard-card-body">
				<h1>➕</h1>
				<h5>Sell a Book</h5>
				<p>Add a new book listing.</p>
				
				<button class="card-button">
					<a href="../seller/add_book.php">Sell a Book</a>
				</button>
			</div>
		</div>

		<div class="dashboard-card">
			<div class="dashboard-card-body">
				<h1>⚙️</h1>
				<h5>Settings</h5>
				<p>Update your account settings.</p>
							
				<button class="card-button">
					<a href="change_password.php">Change Password</a>
				</button>
			</div>
		</div>
	</div>
</div>

<?php 
include("../includes/footer.php"); 
?>