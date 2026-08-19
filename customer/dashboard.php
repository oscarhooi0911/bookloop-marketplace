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

include("../includes/header.php");
?>

<div class="customer-dashboard">

    <!-- Profile Section -->
    <div class="dashboard-profile">

        <div class="dashboard-profile-body">

            <div class="dashboard-profile-info">

                <img
                    src="../upload/profile/<?php echo $user['profile_picture']; ?>"
                    width="120"
                    height="120"
                    class="profile-picture"
                    alt="Profile Picture"
                >

                <div>

                    <h2>
                        <?php echo htmlspecialchars($user['full_name']); ?>
                    </h2>

                    <p class="profile-role">
                        Customer Account
                    </p>

                    <div class="dashboard-buttons">

                        <a href="profile.php" class="dashboard-button dashboard-button-primary">
                            View Profile
                        </a>

                        <a href="edit_profile.php" class="dashboard-button dashboard-button-secondary">
                            Edit Profile
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Navigation -->
    <div class="dashboard-navigation">

        <div class="dashboard-navigation-body">

            <ul class="dashboard-nav">

                <!-- Replace the "#" with the PHP page -->

                <li>
                    <a class="active" href="#">Home</a>
                </li>

                <li>
                    <a href="#">My Books</a>
                </li>

                <li>
                    <a href="#">Wishlist</a>
                </li>

                <li>
                    <a href="#">Orders</a>
                </li>

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

                <!-- put the PHP here -->
                <button class="card-button">Coming Soon</button>

            </div>

        </div>

        <div class="dashboard-card">

            <div class="dashboard-card-body">

                <h1>❤️</h1>

                <h5>Wishlist</h5>

                <p>View your favourite books.</p>

                <a href="wishlist.php" class="card-button">View Wishlist</a>

            </div>

        </div>

        <div class="dashboard-card">

            <div class="dashboard-card-body">

                <h1>➕</h1>

                <h5>Sell a Book</h5>

                <p>Add a new book listing.</p>

                <!-- put the PHP here -->
                <button class="card-button">Coming Soon</button>

            </div>

        </div>

        <div class="dashboard-card">

            <div class="dashboard-card-body">

                <h1>⚙️</h1>

                <h5>Settings</h5>

                <p>Update your account settings.</p>

                <a href="change_password.php" class="card-button">Change Password</a>

            </div>

        </div>

    </div>

</div>


<?php
include("../includes/footer.php");
?>