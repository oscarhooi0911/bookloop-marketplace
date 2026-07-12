<?php

session_start();

include("../authentication/database.php");

$email=$_post['email'];
$password=$_POST['password'];

$stml = mysqli_prepare(
$conn,
"SELECT * FORM users WHERE email=?"
);

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

result = mysqli_stmt_get_result($stmt);

if($user = mysqli_fetch_assoc($result))){
	
	if($password_verify($password, $user['password'])){
		$_SESSION['user_id']=$user['user_id];
		$_SESSION['name']=$user['full_name'];
		$_SESSION['role']=$user['rule'];
		
		if($user['role'] == "staff"){
			header("Location:../staff/dashboard.php");
		} else{
			header(Location:../customer/dashboard.php");
		}
	} else{
		echo "Wrong Password";
	}
} else{
	echo "Email Not Found";
}

?>