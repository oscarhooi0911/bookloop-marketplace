<?php
include("../authentication/check_login.php");
include("../database/database.php");

if($_SESSION['role'] != "customer"){
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

<div class="container mt-5">

    <!-- Profile Section -->
    <div class="card shadow border-0 mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <img src="../upload/profile/<?php echo $user['profile_picture']; ?>"
                     width="120"
                     height="120"
                     class="rounded-circle border me-4">

                <div>

                    <h2 class="mb-1">
                        <?php echo $user['full_name']; ?>
                    </h2>

                    <p class="text-muted mb-3">
                        Customer Account
                    </p>

                    <a href="profile.php" class="btn btn-primary me-2">
                        View Profile
                    </a>

                    <a href="edit_profile.php" class="btn btn-outline-secondary">
                        Edit Profile
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Navigation -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <ul class="nav nav-pills">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">My Books</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Wishlist</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Orders</a>
                </li>

            </ul>

        </div>

    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4">

        <div class="col-md-3">

            <div class="card shadow-sm text-center h-100">

                <div class="card-body">

                    <h1>📚</h1>

                    <h5>My Books</h5>

                    <p class="text-muted">
                        Manage your books for sale.
                    </p>

                    <button class="btn btn-success">
                        Coming Soon
                    </button>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm text-center h-100">

                <div class="card-body">

                    <h1>❤️</h1>

                    <h5>Wishlist</h5>

                    <p class="text-muted">
                        View your favourite books.
                    </p>

                    <button class="btn btn-warning">
                        Coming Soon
                    </button>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm text-center h-100">

                <div class="card-body">

                    <h1>➕</h1>

                    <h5>Sell a Book</h5>

                    <p class="text-muted">
                        Add a new book listing.
                    </p>

                    <button class="btn btn-primary">
                        Coming Soon
                    </button>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm text-center h-100">

                <div class="card-body">

                    <h1>⚙️</h1>

                    <h5>Settings</h5>

                    <p class="text-muted">
                        Update your account settings.
                    </p>

                    <a href="change_password.php" class="btn btn-dark">
                        Change Password
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
include("../includes/footer.php");
?>