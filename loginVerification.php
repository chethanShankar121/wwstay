<?php
session_start();
require "connect.inc.php";
if(!isset($_SESSION['email']))
{
 if(isset($_POST['email_id']) && isset($_POST['pass'])) 			//do the following when login data is sent through ajax request
 {
 	if(!empty($_POST['email_id']) && !empty($_POST['pass']))
 	{
 		$email=mysqli_real_escape_string($link,$_POST['email_id']);
 		$password=mysqli_real_escape_string($link,$_POST['pass']);
 		$password=md5($password);
 		$query="SELECT * FROM `users` WHERE `users`.`email`='$email'";
 		if($result=$link->query($query))
 		{
 			if(mysqli_num_rows($result)>0)
 			{
 				$row=mysqli_fetch_assoc($result);
 				if($row['password']==$password)
 				{
 					$_SESSION['email']=$row['email'];
 					$_SESSION['reg']=$row['reg_no'];
 					echo "login successful";
 				}else{
 					echo "Wrong Password";
 				}
 			}else{
 				echo "Wrong email id";
 			}
 		}else{ 
 			echo "something went wrong. Please try again later";
 		}
 	}
 }
}else{
	header("Location:userProfile.php");
}
 ?>