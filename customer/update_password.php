<?php
include("../authentication/check_login.php");
include("../database/database.php");

$user_id = $_SESSION['user_id'];

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

//Check if new password matches confirm password
if($new_password != $confirm_password){
	header("Location: change_password.php?error=nomatch");
	exit();
}

//Check password strength - length at least 8 at least 1 uppercase, 1 character and 1 number
if(!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $new_password)){
	header("Location: change_password.php?error=weakpassword");
	exit();
}

//Get current password hash from database
$stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

//Check user exist
if(!$user){
	header("Location: change_password.php?error=usernotfound");
	exit();
}
	
//Verify current password
if(!password_verify($current_password, $user['password'])){
	header("Location: change_password.php?error=wrongcurrent");
	exit();
}

//Hash new password
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

//Update password
$stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "si", $new_hash, $user_id);

if(mysqli_stmt_execute($stmt)){
	header("Location:change_password.php?success=1");
	exit();
} else{
	header("Location: change_password.php?error=failed");
	exit();
}

?>