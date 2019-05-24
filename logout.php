<?php 
session_start();
if(isset($_SESSION['email']))
{
	if(isset($_POST['logout']))
	{
		session_destroy();
		echo "logged out";
	}else{
		echo "request problem";
	}
}else{
	header("Location:index.php");
	exit();
}
 ?>