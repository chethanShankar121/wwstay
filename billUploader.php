<?php
session_start();
require "connect.inc.php";
if(isset($_SESSION['email']))
{	//does the following when the add expense button is clicked. form data is submitted through jquery ajax request
	if(isset($_FILES["bill_image"]["name"]) && isset($_POST['expense_name']) && isset($_POST['price']) && isset($_POST['date'])) 
	{
		if(!empty($_POST['expense_name']) && !empty($_POST['price']) && !empty($_POST['date']))
		{
			$expense_name=mysqli_real_escape_string($link,$_POST['expense_name']);
			$price=mysqli_real_escape_string($link,$_POST['price']);
			$date=$_POST['date'];
			$reg_no=$_SESSION['reg'];
			$validextensions = array("jpeg", "jpg", "png");
			$temporary = explode(".", $_FILES["bill_image"]["name"]);
			$file_extension = end($temporary);
			if ((($_FILES["bill_image"]["type"] == "image/png") || ($_FILES["bill_image"]["type"] == "image/jpg") || 
				($_FILES["bill_image"]["type"] == "image/jpeg")) && ($_FILES["bill_image"]["size"] < 10000000)//Approx. 10mb files can be uploaded.
			&& in_array($file_extension, $validextensions))
			{
				if ($_FILES["bill_image"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["bill_image"]["error"] . "<br/><br/>";
				}else
					{
						$sourcePath = $_FILES['bill_image']['tmp_name']; // Storing source path of the file in a variable
						$target_name= uniqid().".".$file_extension;
						$targetPath = "images/bill/".$target_name; // Target path where file is to be stored
						move_uploaded_file($sourcePath,$targetPath) ;
						$email=$_SESSION['email']; // Moving Uploaded file
						$query="INSERT INTO `expenses` 
						(`expense_id`, `reg_no`, `expense_name`, `total_price`, `bill_date`, `bill_image`) 
						VALUES (NULL, '$reg_no', '$expense_name', '$price', '$date', '$target_name')";
						if($link->query($query))
						{
							echo "expense updated";	
						}
					}
			}else{
				echo "Invalid file size or type";
			}
		}else{
			echo "Please fill in all the fields";
		}
	}


	if(isset($_POST['exp_id'])) //returns the row content having expense_id=exp_id
	{
		$expenseID=$_POST['exp_id'];
		$query="SELECT * FROM `expenses` WHERE `expense_id`='$expenseID'";
		if($result=$link->query($query))
		{
			$row=mysqli_fetch_assoc($result);
			$row=json_encode($row); //returns the row content in json encoded format. to calling ajax request
			echo $row;
		}else{
			echo "problem in query";
		}
	}

	//following updates the the expense in tablel
	if(isset($_POST['exp_name']) && isset($_POST['exp_date']) && isset($_POST['exp_price']) 
	 && isset($_POST['update_exp']) && isset($_POST['exp_id']))
	{
		if(!empty($_POST['exp_name']) && !empty($_POST['exp_date']) && !empty($_POST['exp_price']) 
			&& !empty($_POST['update_exp']) && !empty($_POST['exp_id']))
		{
			$exp_name=mysqli_real_escape_string($link, $_POST['exp_name']);
			$exp_date=mysqli_real_escape_string($link, $_POST['exp_date']);
			$exp_price=mysqli_real_escape_string($link, $_POST['exp_price']);
			$reg_no=$_SESSION['reg'];
			$expenseID=$_POST['exp_id'];
			$query="UPDATE `expenses` SET 
			`expense_name`='$exp_name',
			`bill_date`='$exp_date',
			`total_price`='$exp_price'
			WHERE `expense_id`='$expenseID'";
			if($link->query($query))
			{
				echo "Expense Updated";
			}else{
				echo "Could not update the expense. Please try again later";
			}
		}else{
			echo "Please fill in all the fields";
		}
	}

	if(isset($_POST['del_exp']) && isset($_POST['exp_id']))
	{
		$expenseID=$_POST['exp_id'];
		$query="DELETE FROM `expenses` WHERE `expense_id`='$expenseID'";
		if($link->query($query))
		{
			echo "expense deleted";
		}else{
			echo "Could not delete the expense. Please try again later";
		}
	}
}
?>