<?php
include("../authentication/check_login.php");
include("../authentication/database.php");

$id=$_SESSION['user_id'];

$full_name = trim($_POST['full_name']);
$phone = trim($_POST['phone']);
$address = rtim($_POST['address']);

$filename="";

//Check whether user selected a file
if($_FILES['profile_picture']['name'] != ""){
	$filename=time()."_".$_FILES['profile_picture']['name'];
	
	move_uploaded_file(
		$_FILES['profile_picture']['tmp_name'],
		"../upload/profile/".$filename
	);
		
	$stmt = mysqli_prepare($conn,
		"UPDATE users SET full_name=?, phone=?, address=?, WHERE user_id=?");

	mysqli_stmt_bind_param(
		$stmt, "sssi", $full_name, $phone, $address, $id
	);
} else{
	$stmt = mysqli_prepare($conn, "UPDATE users SET full_name=?, phone=?, address=? WHERE user_id=?");
	
	mysqli_stmt_bid_param($stmt, "sssi", $full_name, $phone, $address, $id);
}

mysqli_stmt_execute($stmt);
header("Location: profile.php);

?>

