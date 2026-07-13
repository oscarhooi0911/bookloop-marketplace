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

<div class="container mt-5">

<h2>My Profile</h2>

<hr>

<div class="text-center mb-4">

	<img src="../upload/profile/<?php echo $user['profile_picture']; ?>" width="180" height="180" class="rounded-circle border">

</div>

<table class="table table-bordered">

<tr>

<th>Name</th>

<td><?php echo $user['full_name']; ?></td>

</tr>

<tr>

<th>Email</th>

<td><?php echo $user['email']; ?></td>

</tr>

<tr>

<th>Phone</th>

<td><?php echo $user['phone']; ?></td>

</tr>

<tr>

<th>Address</th>

<td><?php echo $user['address']; ?></td>

</tr>

</table>

<a href="edit_profile.php" class="btn btn-primary">

Edit profile

</a>

<a href="change_password.php" class="btn btn-warning">

Change Password

</a>

<a href="dashboard.php" class="btn btn-secondary">

Back

</a>

</div>

<?php include("../includes/footer.php"); ?>