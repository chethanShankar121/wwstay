<?php
session_start();
if (isset($_SESSION['email'])) {
  header('location:userProfile.php');
}


?>
<!DOCTYPE html>
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
    <link href="css/userLogin.css" rel="stylesheet">
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
      <a class="nav-link active" href="userSignup.php">User Signup</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php">Home</a>
    </li>
</ul>
</nav>
</header>
<section class="loginForm">
	<div class="container login">
	    <div class="login-content row">
	        <div id="login-form" class="col-12 col-md-7">
	            <h2 class="form-title">User Login</h2>
	            <form method="POST" class="form-group register-form" id="register-form">
	                <div class="form-group">
	                    <label for="name"><i class="fa fa-envelope"></i></label>
	                    <input  type="text" id="email" placeholder="Your Email ID" >
	                    <p id="error_email" class="error"></p>
	                </div>
	                 <div class="form-group">
	                    <label for="name"><i class="fa fa-lock"></i></label>
	                    <input type="password"  id="pass" placeholder="Your Password" >
	                    <p id="error_pass" class="error"></p>
	                </div>
	                
	                <div class="form-group form-button">
	                    <input type="button" name="login" id="login_btn" class="btn btn-primary" value="Login">
	                </div>
	            </form>
	        </div>
	        <div class="login-image col-12 col-md-5">
	            <figure><img class="img-responsive" src="images/website/login-image.jpg" alt="sing up image"></figure>
	            <a href="UserSignup.php" class="login-image-link">Not a member? click here</a>
	        </div>
	    </div>
	</div>
</section>

  <!-- jQuery library -->
  <script type="text/javascript" src="javascript/jquery-3.3.1.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>   
  <script type="text/javascript" src="javascript/userLogin.js"></script> 

  </body>
</html>