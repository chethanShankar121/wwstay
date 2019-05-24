
$(document).ready(function() {
	$("#add_expense_btn").click(function(){
		$("#expense_table").append('Some text')
	});


	$("#upload_bill_btn").click(function(e){
		e.preventDefault();
		$("#image_input").click();
	});


	$("#image_input").change(function(obj){
		var imageObj=obj;
		if(imageObj.target.files[0])
		{
			var fileReader = new FileReader();
			fileReader.readAsDataURL(imageObj.target.files[0]);
			fileReader.onload=function()
			{
				$("#bill_image").attr("src",fileReader.result);
			}
		}
	});


	// do the following when add expense button is clicked
	$("#bill_upload_form").on('submit',function(e){
		e.preventDefault();
		var formdata=new FormData(this);
		console.dir(formdata);
		$.ajax({
			type:"post",
			url:"billUploader.php",
			data:formdata,
			cache: false,             // To unable request pages to be cached
			processData:false,
			contentType: false, 
			async:true,
			success:function(data)
			{
				if(data=="expense updated")
				{
					window.location.reload(); //refresh the page when ajax request is successful
				}else{
					alert(data);
					}
			}
		});
		return false;
	});

	$("#table_row td img").click(function(){
		var clickedImage=$(this).attr("src");
		$("#image_viewer").css("display","block");
		$("#image_viewer img").attr("src",clickedImage);
		$("#overlay").css("display","block");
	});
	$("#image_viewer").click(function(){
		$("#image_viewer").css("display","none");
		$("#overlay").css("display","none");
	});
	$("#overlay").click(function(){
		$("#image_viewer").css("display","none");
		$("#overlay").css("display","none");
	});


	var expenseID;
	$(".update_btn").click(function(){
		expenseID = $(this).parent().parent();
		expenseID=expenseID.children(0).html(); 
		console.log(expenseID);
		$("#update_window").css("display","block");
		$("#overlay").css("display","block");
		$.ajax({
			type:"post",
			url:"billUploader.php",
			data:{ exp_id:expenseID},
			success:function(data)
			{
				data=JSON.parse(data);
				$("#exp_name").val(data.expense_name);
				$("#exp_price").val(data.total_price);
				$("#exp_date").val(data.bill_date);
			}
		});
	});


	$("#overlay").click(function(){
		$("#update_window").css("display","none");
		$("#overlay").css("display","none");
	});


	$("#exp_update_btn").click(function(){
		console.log("expense id="+expenseID);
		var expense_name=$("#exp_name").val();
		var expense_price=$("#exp_price").val();
		var expense_date=$("#exp_date").val();
		var update_exp=true;
		$.ajax({
			type:"post",
			url:"billUploader.php",
			data:{exp_name:expense_name, exp_price:expense_price, exp_date:expense_date, update_exp, exp_id:expenseID},
			success:function(data)
			{
				if(data=="Expense Updated")
				{
					window.location.reload();
				}else{
					alert(data);
				}
			}
		});
	});


	$(".delete_btn").click(function(){ 
		var expID = $(this).parent().parent();
		expID=expID.children(0).html(); 
		var delete_expense=true;
		$.ajax({ 				//ajax request to delete the expense
			type:"post",
			url:"billUploader.php",
			data:{del_exp:delete_expense, exp_id:expID},
			success:function(data)
			{
				if(data=="expense deleted")
				{
					window.location.reload();
				}else{
					alert(data);
				}
			}
		});
	});


	$("#sort_by_key a").click(function(e){  //sort the table when clicked
		e.preventDefault();
		var sortKey=$(this).attr("value");
			$("#sortvalue").val(sortKey);
			$("#sortform").submit();		
	});


	$("#logout_btn").click(function(){ 
		var logOut=true;
		$.ajax({						//ajax request to log out of the profile page
			type:"post",
			url:"logout.php",
			data:{logout:logOut},
			success:function(data)
			{
				if(data=="logged out")
				{
					window.location.href="index.php";
				}else{
					alert(data);
				}
			}
		});
	});
});