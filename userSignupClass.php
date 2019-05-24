 <?php 
 ob_start();
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
	
	public function update_user_verification_table()
	{
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

	public function insert_user_verification_table()
	{
		global $link;
		$generated_email_otp=rand(100000, 999999);
		$this->password=md5($this->password);
		$query="INSERT INTO `user_verification` 
		(`sl_no`, `first_name`, `last_name`, `email`, `email_otp`, `email_verified`, `password`)
		VALUES (NULL, '$this->firstName', '$this->lastName', '$this->email', '$generated_email_otp', NULL,
		 '$this->password')";
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

	public function authenticate_user_email() //checks if the email exists in `user_verification` table
	{
		global $link;
		$email=mysqli_real_escape_string($link,$this->email);
		$query="SELECT `email` FROM `user_verification` WHERE `email`='$email'";
		if($run1=$link->query($query))
		{
			if(mysqli_num_rows($run1) > 0)
			{
				$this->update_user_verification_table();
			}else{
				$this->insert_user_verification_table();
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
 
 function send_email($email_otp)
	{
		$to=$_SESSION["email"];
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
?>