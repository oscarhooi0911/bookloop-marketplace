<?php

include("../authentication/check_staff.php");
include("../includes/header.php");

?>

<div class="staff-dashboard">

	<!-- Staff Profile Section -->
	<div class="staff-profile">
		<div class="staff-profile-body">
			<div class="staff-profile-info">
				<img
					src="../upload/profile/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>"
					width="90"
					height="90"
					class="staff-profile-picture"
					alt="Profile Picture"
				>

				<div>
					<h2>
						Welcome,
						<?php echo htmlspecialchars($_SESSION['name']); ?>
					</h2>
					<p>Staff Dashboard</p>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Dashboard Cards -->
	<div class="staff-dashboard-cards">

		<!-- Manage Users -->
		<div class="staff-dashboard-card">
			<div class="staff-dashboard-card-body">
				<h3>👥</h3>
				<h5>Manage Users</h5>
				<p>View and manage customer accounts.</p>
				<a href="manage_users.php" class="staff-card-button">Manage Users</a>
			</div>
		</div>

		<!-- Manage Books -->
		<div class="staff-dashboard-card">

			<div class="staff-dashboard-card-body">

				<h3>📚</h3>

				<h5>Manage Books</h5>
				<p>Approve and manage book listings.</p>
				<a href="manage_books.php" class="staff-card-button">Manage Books</a>
			</div>
		</div>
		
		<!-- Reports -->
		<div class="staff-dashboard-card">
			<div class="staff-dashboard-card-body">
				<h3>📊</h3>
				<h5>Reports</h5>
				<p>Generate sales and user reports.</p>
				<a href="reports.php" class="staff-card-button">Reports</a>
			</div>
		</div>
	</div>
</div>

<?php
include("../includes/footer.php"); 
?>
