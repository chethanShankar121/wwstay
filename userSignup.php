<!DOCTYPE html>
<?php 
session_start();
if(!isset($_SESSION['email']))
{

 ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>WWStay | User Signup</title>

    <!-- font awesome css file -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- signup page css -->
    <link href="css/userSignup.css" rel="stylesheet">
    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
  </head>
  <body>
  
  <!-- Pre Loader -->
  <div id="aa-preloader-area">
    <div class="pulse"></div>
  </div>
  <div class="overlay">
  </div>
<header id="header_section">
<nav id="navigation">
  <ul class="nav justify-content-end">
     <li class="nav-item">
      <a class="nav-link active" href="userLogin.php">User Login</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php">Home</a>
    </li>
</ul>
</nav>
</header>
<section class="signupForm">
	<div class="container signup">
	    <div class="signup-content row">
	        <div id="signup-form" class="col-12 col-md-7">
	            <h2 class="form-title">User Sign up</h2>
	            <form method="POST" class="form-group register-form" id="register-form">
	                <div class="form-group">
	                    <label for="name"><i class="fa fa-user"></i></label>
	                    <input  type="text" name="name" id="fname" placeholder="First Name" >
	                    <p id="error_fname" class="error"></p>
	                </div>
	                 <div class="form-group">
	                    <label for="name"><i class="fa fa-user"></i></label>
	                    <input type="text" name="name" id="lname" placeholder="Last Name" >
	                    <p id="error_lname" class="error"></p>
	                </div>
	                <div class="form-group">
	                    <label for="pass"><i class="fas fa-lock"></i></label>
	                    <input type="password" name="pass" id="pass" placeholder="Password" >
	                    <span><i class="show" id="show_pass">show</i></span>
	                    <p id="error_pass" class="error"></p>
	                    <div id="pass_suggest">
	                    	<p id="total_char"><i class="fas"></i> Password should have at least 8 characters</p>
	                    	<p id="white_space"><i class="fas"></i> White space is not allowed in Password</p>
	                    	<p id="pass_num"><i class="fas"></i> Password should contain at least one Number</p>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="re-pass"><i class="fas fa-repeat"></i></label>
	                    <input type="password" name="repass" id="repass" placeholder="Repeat your password" >
	                    <span><i class="show" id="show_repass">show</i></span>
	                    <p id="error_repass" class="error"></p>
	                </div>
	                <div class="form-group">
	                    <input type="checkbox" name="tnc" id="tnc" class="agree-term" />
	                    <label for="tnc" class="label-agree-term">I agree to all   
	                        <a href="#" class="term-conditions">Terms and Conditions</a></label>
	                    <p id="error_tnc" class="error"></p>  
	                </div>
	                <div class="form-group form-button">
	                    <input type="button" name="signup" id="signup_btn" class="btn btn-primary" value="Register">
	                </div>
	            </form>
	        </div>
	        <div id="email_section" class="col-12 col-md-7">
	        	<h2 class="form-title">User Sign up</h2>
        		<div class="row">
        			<div class="col-12 col-md-8">
        				<input type="text" id="email" placeholder="Your Email Address">
        				<p id="resend_message"></p>
        			</div>
        			<div class="col-12 col-md-4">
        				<input type="button" id="send_otp_btn" class="btn btn-primary" value="Send OTP">
        				<input type="button" id="resend_otp_btn" class="btn btn-link" value="Resend OTP">
        			</div>
        		</div>
        		<div class="row" id="otp_section">
					<label for="">Enter the six digit OTP sent to your email:</label>
    				<div class="col-12 col-md-8">
    					<input type="text" id="otp" placeholder="######" maxlength="6">
        			</div>
        			<div class="col-12 col-md-4">
        				<input type="button" class="btn btn-success" id="verify_otp_btn" value="Verify">
        			</div>
				</div>
	        </div>
	        <div class="signup-image col-12 col-md-5">
	            <figure><img class="img-responsive" src="images/website/signup-image.jpg" alt="sing up image"></figure>
	            <a href="userLogin.php" class="signup-image-link">I am already a member</a>
	        </div>
	    </div>
	</div>
</section>
<div id="overlay2">
	<div istyle="width:50%;height:50%;">
  		<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  		Sending OTP...
</button>
  	</div>
</div>
  <!-- jQuery library -->
  <script src="javascript/jquery-3.3.1.js"></script> 
  <script src="bootstrap/js/bootstrap.js"></script>   
  <script src="javascript/userSignup.js"></script> 

  </body>
</html>
<?php 

}else{
	header("Location:index.php");
} ?>