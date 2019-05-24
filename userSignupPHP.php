<?php
require "connect.inc.php";
session_start();
ob_start();
// user calss to store form data
class user{
	 var $firstName;
	 var $lastName;
	 var $email;
	 var $password;

	 public function test_input($data)
			 {
		        $data = trim($data);
		        $data = stripslashes($data);
		        $data = htmlspecialchars($data);
		        return $data;
			 }
	public function get_data($fname,$lname,$pass,$email)
	{
		 //new object of class user() is created
		$this->firstName=$this->test_input($fname);
		$this->lastName=$this->test_input($lname);
		$this->password=$pass;
		$this->email=$this->test_input($email);

	}
	
	public function update_user_verification_table() //function to update the form data if the email already exists in the
	{												//user_verification table
		global $link;
		$_SESSION['otp']=$generated_email_otp=rand(100000, 999999);
		$query="UPDATE `user_verification` SET 
				`first_name` = '$this->firstName', 
				`last_name` = '$this->lastName', 
				`email_otp` = '$generated_email_otp', 
				`password` = '$this->password' 
				WHERE `user_verification`.`email` = '$this->email'";
		if($run1=$link->query($query))
		{
			$email_message=send_email($generated_email_otp);
			if($email_message=="email sent")
			{
				echo "OTP sent";
			}else{
				echo "Could not send the otp. Please try again later.";
			}
		}
	}

	public function insert_user_verification_table() //function to insert new values to user_verification table with new email
	{
		global $link;
		$generated_email_otp=rand(100000, 999999); //generate random otp
		$this->password=md5($this->password); //hash the password
		$query="INSERT INTO `user_verification` 
		(`sl_no`, `first_name`, `last_name`, `email`, `email_otp`, `email_verified`, `password`)
		VALUES (NULL, '$this->firstName', '$this->lastName', '$this->email', '$generated_email_otp', NULL,
		 '$this->password')";
		if($run1=$link->query($query))
		{
			$email_message=send_email($generated_email_otp); //call send_email() method to send the generated otp
			if($email_message=="email sent")
			{
				echo "OTP sent"; //echo this if email is sent successfully
			}else{
				echo "Could not send the otp. Please try again later.";
			}
		}
	}

	public function authenticate_user_email() //checks if the email exists in `user_verification` table
	{
		global $link;
		$email=mysqli_real_escape_string($link,$this->email);
		$query="SELECT `email` FROM `user_verification` WHERE `email`='$email'";
		if($run1=$link->query($query))
		{
			if(mysqli_num_rows($run1) > 0)
			{
				$this->update_user_verification_table(); //call the update_user_verification_table() if the email exists in users_verification table
			}else{
				$this->insert_user_verification_table(); // call insert_user_verification_table() if the email does not exist in users_verification table
			}
		}
	}

	public function check_for_email() //checks if the  email exists in `users` table
	{
		global $link;
		$email=mysqli_real_escape_string($link,$this->email);
		$query="SELECT `email` FROM `users` WHERE `email`='$email'"; //query to check the email in `users` table
		if($result=$link->query($query))
		{
			if(mysqli_num_rows($result)>0)
			{
				echo "An account already exists with this email id";
			}else{								  //the email does not exist in the `users` table
				$this->authenticate_user_email(); //now check for the email in `user_verification` table
			}
		}
	}
 }
 
 function send_email($email_otp) //function to sennd the email
	{
		$to=$_POST["email_addr"];
		$otp=$email_otp;
		$subject="Email verification";
		$from="WWStay Pvt Ltd";
		$message=$otp." is your email verification code";
		$headers="from: WWStay Pvt Ltd";
		$handler=mail($to, $subject,$from,$message,$headers);
		if($handler)
		{
			return "email sent";
		}else{
			return "email not sent";
		}
	}
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['pass'])) //when user clicks the signup button, data comes to this line
{
	if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['pass']))//checks for null values
	{
		session_destroy();
		session_start();		
		if(!isset($_SESSION['email']))
		{
			// storing the form data in session variables for later use
			$_SESSION['fname']=$_POST['fname'];
			$_SESSION['lname']=$_POST['lname'];
			$_SESSION['pass']=$_POST['pass'];
			// form data has been stored, sending the message back to jquery page through AJAX
			printf("ok");
		}else{
			echo "session problem";
		}
	}
}

if(isset($_POST['email_addr'])) //does the following when email is submitted
{
	if(!empty($_POST['email_addr'])) //checks if email variable is empty
	{
		$newuser= new user(); 
		$email=$_POST['email_addr'];
		$newuser->get_data($_SESSION['fname'], $_SESSION['lname'], $_SESSION['pass'], $_POST['email_addr']); //call get_data function
		$newuser->check_for_email(); //call check_for_email() function to check if the email exists in database
	}
}

function getRandomString() //function to create random string for user registration_number
{
	$length = 8;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

if(isset($_POST['verify_otp']) && isset($_POST['email'])) //does the followiing when the otp is submitted
{
	if(!empty($_POST['verify_otp']) && !empty($_POST['email']))
	{
		$email=$_POST['email'];
		$query1="SELECT * FROM `user_verification` WHERE `email`='$email'"; //query to select data matching with entered email
		if($result1=$link->query($query1))
		{
			$row=mysqli_fetch_assoc($result1);
			$generated_otp=$row['email_otp']; //access the previously stored otp in a variable
			if($_POST['verify_otp']==$generated_otp) //check if the entered otp matches with generated otp(stored previously in table)  
			{
					$first_name=$row['first_name'];
					$last_name=$row['last_name'];
					$email=$row['email'];
					$password=$row['password'];
					$dt = new DateTime();
					$now= $dt->format('Y-m-d H:i:s');
					$reg_no=getRandomString(); //call the random reg_number generator function
					$query3="INSERT INTO `users` 
					(`sl_no`, `reg_no`, `first_name`, `last_name`, `email`, `password`, `last_login_time`) 
					VALUES (NULL, '$reg_no', '$first_name', '$last_name', '$email', '$password', '$now')";//querry to insert the user data
																										//in users table
					if($link->query($query3))
					{
						$query4="DELETE FROM `user_verification` WHERE `user_verification`.`email` = '$email'";
						if($link->query($query4))
						{
							$_SESSION['email']=$email;
							$_SESSION['reg']=$reg_no;
							echo "email verified"; //echos this to the ajax request. now signup is successful
						}
					}
			}else{
				echo "wrong otp";
			}
		}else{
			echo "Something is wrong, Please try again later";
		}
	}else{
		echo "Please enter the OTPs";
	}
}

if(isset($_POST['resend_otp'])) //does the following when resend otp request is submitted
{
	$email=$_POST['email'];
	$_SESSION['otp']=$generated_email_otp=rand(100000, 999999);
	$query="UPDATE `user_verification` SET `email_otp` = '$generated_email_otp'
			WHERE `user_verification`.`email` = '$email'";
	if($run1=$link->query($query))
	{
		$email_message=send_email($generated_email_otp);
		if($email_message=="email sent")
		{
			echo "OTP resent";
		}else{
			echo "Could not send the otp. Please try again later.";
		}
	}
}

?>