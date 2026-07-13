<?php

session_start();

include("../database/database.php");

$email=$_POST['email'];
$password=$_POST['password'];

$stmt = mysqli_prepare(
$conn,
"SELECT * FROM users WHERE email=?"
);

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if($user = mysqli_fetch_assoc($result)){
	
	if(password_verify($password, $user['password'])){
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['name'] = $user['full_name'];
		$_SESSION['role'] = $user['role'];
		$_SESSION['profile_picture'] = $user['profile_picture'];
		
		if($user['role'] == "staff"){
			header("Location:../staff/dashboard.php");
			exit();
		} else{
			header("Location:../customer/dashboard.php");
			exit();
		}
	} else{
		header("Location: ../login.php?error=wrongpassword");
	}
} else{
	header("Location: ../login.php?error=emailnotfound");
}

?>