<?php
include(../autentication/check_login.php");

if($_SESSION['role'] != "customer"){
	header("Location: ../staff/dashboard.php");
	exit();
}
?>

<!DOCTYPE html>
<heml>
<head>

<title>Customer Dashboards</title>

<link hred="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<img src="../upload/profile/<?php echo $user['profile_picture']; ?>" width="70" height="70" class="rounded-circle">

<div class="container mt-5">

<h2>
	Welcome
	<?php echo $_SESSION['name']; ?>
</h2>

<hr>

<div class="row">
<div class="col-md-4">

<div class="card">

<div class="card-body">

<h4>My Profile</h4>

<a href="profile.php class="btn btn-primary">
View Profile
</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card">

<div class="card-body">

<h4>My Books</h4>

<button class="btn btn-seccess">
Coming Soon
</button>

</div>

</div>

</div>

<div class="col-md-4">

div class="card">

<div class="card-body">

<h4>WishList</h4>

<button class="btn btn-warning">
Coming Soon
</button>

</div>

</div>

</div>

<br>

<a href="../logout/php" class="btn btn-danger">
logout
</a>

</div>

</body>

</html>