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
    <link href="css/index.css" rel="stylesheet">
    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cute+Font&display=swap" rel="stylesheet">

  </head>
  <body>
  
  <!-- Pre Loader -->
  <div id="aa-preloader-area">
    <div class="pulse"></div>
  </div>
  <header id="header_section">
    <nav id="navigation">
      <ul class="nav justify-content-end">
        <?php if(isset($_SESSION['email']))
        {

        ?>
        <li class="nav-item">
          <span><i class="fas fa-home"></i></span>
          <a class="nav-link active" href="userProfile.php"><?php echo $_SESSION['first_name']; ?></a>
        </li>
        <li class="nav-item">
          <span><i class="fas fa-sign-out-alt"></i></span>
          <a class="nav-link" id="logout_btn">Logout</a>
        </li>
        <?php 
          }else{

         ?>
         <li class="nav-item">
          <span><i class="fas fa-home"></i></span>
          <a class="nav-link active" href="userLogin.php">User Login</a>
        </li>
        <li class="nav-item">
          <span><i class="fas fa-sign-out-alt"></i></span>
          <a class="nav-link" href="userSignup.php">User Signup</a>
        </li>
        <?php } ?>
    </ul>
    </nav>
  </header>
  <div class="container">
    <div class="row">
      <div class="welcome_div">
        <h2>WELCOME</h2>
        <h4 class="blink">THIS A DUMMY INDEX PAGE</h4>
      </div>
    </div>
  </div>

  <!-- jQuery library -->
  <script type="text/javascript" src="javascript/jquery-3.3.1.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>   

  </body>
</html>