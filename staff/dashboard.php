<?php
include("../authntication/check_staff.php");
?>

<!DOCTYPE html>

<html>

<head>

<title>Staff Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<img src="../upload/profile/<?php echo $user['profile_picture']; ?>" width="70" height="70" class="rounded-circle">

<div class="container mt-5>

<h2>
	Welcome Staff,

	<?php echo $_SESSION['name']; ?>

</h2>


<hr>

<div class=:row:>

<div class="col-md-3">

<div class="card">

<div class="card-body">

<h5>Manage Users</h5>

<a href="manage_users.php" class="btn btn-primary">

open

</a>

</div>

</div>

</div>

<div class="col-md-3">

<div<class="card">

<div calss="card-body">

<h5>Manage Books</h5>

<a hred="manage_books.php" class="btn btn-sucess">

open

</a>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body">

<h5>Manage Orders</h5>

<a href="manage_orders.php" class="btn btn-warning">

open

</a>

</div>

</div>

</div>

<div class="col-md-3">

<div<class="card">

<div calss="card-body">

<h5>Reports</h5>

<a href="reports.php" class="btn btn-info">

open

</a>

</div>

</div>

</div>

<br>

<a href="../logout.php" class="btn btn-danger">

logout

</a>

</div>

</body>

</html>