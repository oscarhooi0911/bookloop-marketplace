<?php 
include("../database/database.php");

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

//Check if new password matches confirm password
if($password != $confirm_password){
	header("Location: ../register.php?error=nomatch");
	exit();
}

//Check password strength - length at least 8 at least 1 uppercase, 1 character and 1 number
if(!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $new_password)){
	header("Location: change_password.php?error=weakpassword");
	exit();
}

$stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email=?");

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if(mysqli_stmt_num_rows($stmt) > 0){
	header("Location: ../register.php?error=email_exists");
	exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn,
"INSERT INTO users(full_name, email, phone, address, password, role)
VALUES(?,?,?,?,?,'customer')"
);

mysqli_stmt_bind_param(
$stmt,
"sssss",
$full_name,
$email,
$phone,
$address,
$hashedPassword
);

if(mysqli_stmt_execute($stmt)){
	header("Location: ../login.php?register=success");
	
} else{
	echo "Fail to register";
}
?>