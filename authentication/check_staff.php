<?phpsession_start();

if(!isset($_SESSION['user_id'])){
	header("Location: ../login.php");
	exit();
}

if($_SESSION['role'] != "staff"){
	header("Location: ../customer/dashboard.php");
	exit();
}
?>