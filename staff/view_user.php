<?php
include("../authentication/check_login.php");
include("../database/database.php");

// Get user ID from URL
$user_id = (int) ($_GET['id'] ?? 0);

// Check whether valid ID was provided
if ($user_id <= 0) {
    header("Location: manage_users.php");
    exit;
}

// Get user information
$stmt = mysqli_prepare(
    $conn,
    "SELECT user_id, full_name, email, phone, address, role, profile_picture
     FROM users
     WHERE user_id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);


// User not found
if (!$user) {
    header("Location: manage_users.php");
    exit;
}

include("../includes/header.php");
?>

<div class="profile-page">

    <h2>User Details</h2>

    <hr>


    <!-- Profile Picture -->
    <div class="profile-picture-section">

        <?php if (!empty($user['profile_picture'])): ?>

            <img
                src="../upload/profile/<?php echo htmlspecialchars($user['profile_picture']); ?>"
                alt="Profile Picture"
                class="profile-picture-large"
            >

        <?php else: ?>

            <img
                src="../image/default-profile.png"
                alt="Default Profile Picture"
                class="profile-picture-large"
            >

        <?php endif; ?>

    </div>

    <!-- User Information -->
    <table class="profile-table">

        <tr>
            <th>User ID</th>
            <td><?php echo (int) $user['user_id']; ?></td>
        </tr>

        <tr>
            <th>Full Name</th>
            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
        </tr>

        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>

        <tr>
            <th>Phone</th>
            <td>
                <?php
                echo !empty($user['phone'])
                    ? htmlspecialchars($user['phone'])
                    : 'Not provided';
                ?>
            </td>
        </tr>

        <tr>
            <th>Address</th>
            <td>
                <?php
                echo !empty($user['address'])
                    ? nl2br(htmlspecialchars($user['address']))
                    : 'Not provided';
                ?>
            </td>
        </tr>

        <tr>
            <th>Role</th>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
        </tr>

    </table>

    <div class="profile-buttons">

        <a
            href="manage_users.php"
            class="profile-button profile-button-secondary"
        >
            Back to Users
        </a>


        <?php if ((int) $user['user_id'] !== (int) $_SESSION['user_id']): ?>

            <a
                href="delete_user.php?id=<?php echo (int) $user['user_id']; ?>"
                class="profile-button"
                style="background: var(--danger-color); color: white;"
                onclick="return confirm('Are you sure you want to delete this user?');"
            >
                Delete User
            </a>

        <?php endif; ?>

    </div>

</div>

<?php include("../includes/footer.php"); ?>
