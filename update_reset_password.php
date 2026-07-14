<?php include("database/database.php");

$user_id = $_POST['user_id'];

$password = $_POST['password'];

$confirm_password = $_POST['confirm_password'];

//check password match
if($password != $confirm_password){
	header("Location: reset_password.php?error=nomatch");
	exit();
}

//password rule
if(strlen($password) <8 ||
!preg_match("/[A-Z]/", $password) ||
!preg_match("/[0-9]/", $password) ||
!preg_match("/[@#$!]/", $password)){
	echo "Password must contain:";
	echo "<br>- At least 8 characters";
	echo "<br>- One uppercase letter";
	echo "<br>- One number";
	echo "<br>- One special character (@ # $ !)";
	
	exit();
	
}

//hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

//update database/database
$stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "si", $hash, $user_id);

if(mysqli_stmt_execute($stmt)){
	header("Location: login.php?reset=success");
	exit();
} else{
	echo" failed to update password.";
}

?>