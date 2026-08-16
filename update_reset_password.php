<?php include("database/database.php");

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['reset_user_id'])) {
	header("Location: forgot_password.php");
	exit();
}

$user_id = (int) $_SESSION['reset_user_id'];

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
	header("Location: reset_password.php?error=weakpassword");
	exit();
	
}

//hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

//update database/database
$stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE user_id=?");

mysqli_stmt_bind_param($stmt, "si", $hash, $user_id);

if(mysqli_stmt_execute($stmt)){
	unset($_SESSION['reset_user_id']);
	header("Location: login.php?reset=success");
	exit();
} else{
	echo" failed to update password.";
}

?>
