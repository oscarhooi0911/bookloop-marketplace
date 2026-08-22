<?php

include("../authentication/check_staff.php");
include("../database/database.php");

// Search
$search = trim($_GET['search'] ?? '');

// Get users
if ($search !== '') {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id, full_name, email, phone, role, created_at
         FROM users
         WHERE full_name LIKE ?
         OR email LIKE ?
         ORDER BY created_at DESC"
    );

    $keyword = "%" . $search . "%";

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $keyword,
        $keyword
    );

} else {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT user_id, full_name, email, phone, role, created_at
         FROM users
         ORDER BY created_at DESC"
    );

}

mysqli_stmt_execute($stmt);

$users = mysqli_stmt_get_result($stmt);

// Number of users
$countResult = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM users"
);

$countData = mysqli_fetch_assoc($countResult);
$totalUsers = $countData['total'];

include("../includes/header.php");
?>

<div class="manage-users-page">

    <div class="manage-users-header">
        <div>
            <h2>Manage Users</h2>
            <p>View and manage customer and staff accounts.</p>
        </div>

        <div class="user-count">
            <span>Total Users</span>
            <strong><?php echo $totalUsers; ?></strong>
        </div>
    </div>

    <!-- Search -->
    <div class="manage-users-search">
        <form method="GET">
            <input
                type="text" name="search" placeholder="Search by name or email..."
                value="<?php echo htmlspecialchars($search); ?>"
            >
            <button type="submit">Search</button>
            <?php if ($search !== ''): ?>
                <a href="manage_users.php">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Users Table -->
    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (mysqli_num_rows($users) === 0): ?>
                    <tr>
                        <td colspan="7" class="no-users"> No users found.</td>
                    </tr>
                <?php else: ?>

                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                        <tr>
                            <!-- ID -->
                            <td>
                                <?php echo (int) $user['user_id'];?>
                            </td>

                            <!-- Name -->
                            <td>
                                <div class="user-name">
                                    <strong>
                                        <?php echo htmlspecialchars($user['full_name']); ?>
                                    </strong>
                                </div>
                            </td>

                            <!-- Email -->
                            <td>
                                <?php echo htmlspecialchars($user['email']);?>
                            </td>

                            <!-- Phone -->
                            <td>
                                <?php echo !empty($user['phone'])? htmlspecialchars($user['phone']): 'Not provided';?>

                            </td>

                            <!-- Role -->
                            <td>
                                <?php if ($user['role'] === 'staff'): ?>
                                    <span class="user-role user-role-staff">Staff</span>
                                <?php else: ?>
                                    <span class="user-role user-role-customer">Customer</span>
                                <?php endif; ?>
                            </td>

                            <!-- Created -->
                            <td>
                                <?php echo date("d M Y", strtotime($user['created_at']));?>
                            </td>

                            <!-- Action -->
                            <td>
                                <div class="user-actions">
                                    <a
                                        href="view_user.php?id=<?php echo (int) $user['user_id']; ?>"
                                        class="user-action-view"
                                    >
                                        View
                                    </a>

                                    <?php if ((int) $user['user_id'] !== (int) $_SESSION['user_id']): ?>
                                        <a
                                            href="delete_user.php?id=<?php echo (int) $user['user_id']; ?>"
                                            class="user-action-delete"
                                            onclick="return confirm('Are you sure you want to delete this user?');"
                                        >
                                            Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include("../includes/footer.php");
?>