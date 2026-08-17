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

// Prevent user from deleting their own account
if ($user_id === (int) $_SESSION['user_id']) {
    header("Location: manage_users.php");
    exit;
}

// Check whether user exists
$stmt = mysqli_prepare(
    $conn,
    "SELECT user_id FROM users WHERE user_id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!mysqli_fetch_assoc($result)) {
    header("Location: manage_users.php");
    exit;
}

// Delete user
$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM users WHERE user_id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);


if (mysqli_stmt_execute($stmt)) {

    header("Location: manage_users.php?delete=success");
    exit;

} else {

    die("Failed to delete user.");

}
?>