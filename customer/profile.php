<?php

include("../authentication/check_login.php");
include("../database/database.php");

$id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

include("../includes/header.php");
?>

<div class="profile-page">

    <h2>My Profile</h2>
    <hr>
    <div class="profile-picture-section">
        <img
            src="../upload/profile/<?php echo htmlspecialchars($user['profile_picture']); ?>"
            width="180"
            height="180"
            class="profile-picture-large"
            alt="Profile Picture"
        >
    </div>

    <table class="profile-table">
        <tr>
            <th>Name</th>
            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo htmlspecialchars($user['phone']); ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?php echo htmlspecialchars($user['address']); ?></td>
        </tr>
    </table>


    <div class="profile-buttons">
        <a href="edit_profile.php" class="profile-button profile-button-primary">
            Edit Profile
        </a>
		
        <a href="change_password.php" class="profile-button profile-button-warning">
            Change Password
        </a>

        <a href="dashboard.php" class="profile-button profile-button-secondary">
            Back
        </a>
    </div>
</div>

<?php 
include("../includes/footer.php"); 
?>