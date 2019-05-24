<!DOCTYPE html>
<?php
require_once "connect.inc.php";
session_start();
if(isset($_SESSION['email']))
{
	?>
<html>
  <head>
    <meta charset="utf-8">
        <link type="stylesheet" href=""/>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="css/userProfile.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <title>Document</title>
  </head>
  <body>
  	<div id="overlay">
  		
  	</div>
  	<header id="header_section">
  		<nav id="navigation">
  			<ul class="nav justify-content-end">
			  <li class="nav-item">
			   	<span><i class="fas fa-home"></i></span>
			    <a class="nav-link active" href="index.php">Home</a>
			  </li>
			  <li class="nav-item">
			  	<span><i class="fas fa-sign-out-alt"></i></span>
			    <a class="nav-link" id="logout_btn">Logout</a>
			  </li>
			</ul>
  		</nav>
  	</header>
    <div class="container-fluid">
    	<div class="row">
    		<div id="menu" class="col-12 col-md-2">
    			<ul id="menu_list">
    				<li><a href="">Expense Log</a></li>
    				<li><a href="">Add Expense</a></li>
    			</ul>
    		</div>
    		<div class="col-12 col-md-10">
    			<div class="row">
    				<div class="col-12 col-md-6">
    					<h4>Your Expenses' Log</h4>
    				</div>
    				<div class="col-12 col-md-6">
    					<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" 
						  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Sort Expenses By
						  </button>
						  <div class="dropdown-menu" id="sort_by_key" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item"  value="expense_name">Expense Name</a>
						    <a class="dropdown-item"  value="total_price">Total Price</a>
						    <a class="dropdown-item"  value="bill_date">Bill Date</a>
						  </div>
						</div>
    				</div>
    			</div>
    			<div id="expense_log">
	    			<table class="table table-bordered" id="expense_table">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Expense Name</th>
					      <th scope="col">Total Price</th>
					      <th scope="col">Date</th>
					      <th scope="col">Bill Image</th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					    
					    	<?php
					    	$total=0;
					    	$sort_key="";
					    	$reg_no=$_SESSION['reg'];
					    	if(isset($_POST['sort_key']) && !empty($_POST['sort_key']))
					    	{
								$sort_key = $_POST['sort_key'];
								$query="SELECT * FROM `expenses` WHERE `expenses`.`reg_no`='$reg_no' ORDER BY `$sort_key`";					    		
					    	}else 
					    		$query="SELECT * FROM `expenses` WHERE `expenses`.`reg_no`='$reg_no'";
					    		if($result=$link->query($query))
					    		{
					    			$i=1;
					    			while($row=mysqli_fetch_assoc($result))
					    			{
					    	?>
					    	<tr id="table_row">
					    		<td style="display:none;"><?php echo $row['expense_id']; ?></td>
								<th scope="col"><?php echo $i++; ?></th>
								<td><?php echo $row['expense_name']; ?></td>
								<td><?php echo $row['total_price']; ?></td>
								<td><?php echo $row['bill_date']; ?></td>
								<td><img id="bill_image_display" src="<?php echo 'images/bill/'.$row['bill_image'] ?>" title="click image to view"></td>
								<td><button class="btn btn-link update_btn" >Update</button>
									<button class="btn btn-link delete_btn" >Delete</button>
								</td>						      
					    </tr>
					    <?php 
					    		$total+=$row['total_price'];
					    			}
					    		}
					    	 ?>
					  </tbody>
					  <thead>
					  	<tr>
					  		<th colspan="2">Total Expense :</th>
					  		<th><?php echo $total; ?></th>
					  		
					  		<!-- <td colspan="3"><button class="btn btn-link" id="add_expanse_btn">Add Expense</button></td> -->
					  	</tr>
					  </thead>
					</table>
					<div id="image_viewer">
						<img src="images/bill/5ce6ca49b113d.jpg" alt="">
					</div>
					<div id="update_window">
						<div class="form-group">
							<label for="exp_name"> Expense Name</label>
							<input type="text" id="exp_name" class="form-control" placeholder="Expense Name" value="">
							<label for="exp_price">Total Price</label>
							<input type="text" id="exp_price" class="form-control" placeholder="Total Price" vlaue="">
							<label for="exp_date">Bill Date</label>
							<input type="date" id="exp_date" class="form-control" >
							<input type="button" class="btn btn-primary form-control" id="exp_update_btn" value="Update">
						</div>
					</div>
					<form action="billUploader.php" method="POST" id="bill_upload_form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-12 col-md-3">
								<input type="text" name="expense_name" class="form-control" placeholder="Expense Name">
							</div>
							<div class="col-12 col-md-2">
								<input type="text" name="price" class="form-control" placeholder="Total Price">
							</div>
							<div class="col-12 col-md-3">
								<input type="text" name="date" class="form-control" placeholder="Date" onfocus="type='date'" onfocusout="type='text'">
							</div>
							<div class="col-12 col-md-2">
								<img src="" alt="" id="bill_image">
								<button id="upload_bill_btn" class='btn btn-link'>Upload Bill Image</button>
								<div id="image_form">
									<input type="file" name="bill_image" class="form-control" id="image_input">
								</div>
							</div>
							<div class="col-12 col-md-2">
								<input type="submit"  name="submit" id="expense_submit_btn" class="btn btn-success" value="Add Expense">
							</div>
						</div>
					</form>
    			</div>
    		</div>
    	</div>
    </div>
    <form action="userProfile.php" id="sortform" method="POST" style="display:none">
    	<input name="sort_key" value="" id="sortvalue">
    </form>
<script type="text/javascript" src="javascript/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>   
<script type="text/javascript" src="javascript/userProfile.js"></script> 
  </body>
</html>

<?php 
}else{
	header("Location:index.php");
}
 ?>