$(document).ready(function(){
	$("#login_btn").click(function(){      
		var email=$("#email").val();
		var password=$("#pass").val();
		if(email=="")
		{
			$("#error_email").html("Please enter the email");
		}else{
			$("#error_email").html();
		}
		if(password=="")
		{
			$("#error_pass").html("Please enter the password");
		}else{
			$("#error_pass").html();
		}
		if(email!="" && password!="")
		{
			$("#error_email").html();
			$("#error_pass").html();
			if(email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i))
			{
				$("#error_email").html();
				$.ajax({								//ajax request to loginVerification.php page to login
					type:"post", 
					url:"loginVerification.php",
					data:{email_id:email, pass:password},
					success:function(data)
					{
						if(data=="login successful")
						{
							window.location.href="userProfile.php";
						}else{
							alert(data);
						}
					}
				});
			}else{
				$("#error_email").html("Invalid Email");
			}
		}
	});
});