$(document).ready(function()
{
	
	$("#signup_btn").click(function(){  //runs when signup button is clicked
		var first_name=$("#fname").val(); //form data extracted here
		var last_name=$("#lname").val();
		var password=$("#pass").val();
		var re_password=$("#repass").val();
		if(first_name=="") //display message for empty field
		{
			$("#error_fname").html("Please enter the First Name");
		}else{
			$("#error_fname").html("");
		}

		if(last_name=="") //display message for empty field
		{
			$("#error_lname").html("Please enter the Last Name");
		}else{
			$("#error_lname").html("");
		}

		if(password=="") //display message for empty field
		{
			$("#error_pass").html("Please set a password");
		}else{
			$("#error_pass").html("");
		}

		if(re_password=="") //display message for empty field
		{
			$("#error_repass").html("Please Re-enter password");
		}else{
			$("#error_repass").html("");
		}

		if(first_name!="" && last_name!="" && password!="" && re_password!="") //run this if all the fields are filled
		{
			if($("#tnc").is(":checked")) // check if the terms and condition is checked
			{
				$("#error_tnc").html("");
				if(password.length>=8) //checks id password length is 8 characters minimum
				{
					if(password.match(/^\S*$/)) //checks if password contains spaces
					{
						if(password.match(/\d/)) //checks if the password contains numbers
						{
							if(password==re_password) //checks if both passwords match
							{
								$("#error_repass").html("");
								$.ajax({ //ajax request with all the form data 
									type:"post",
									url:"userSignupPHP.php", //sending the form data to userSignupPHP.php
									data:{fname:first_name, lname:last_name, pass:password}, //sending form data as object
									success:function(data) // does this if the ajax request is successful
									{
										if(data=="ok")
										{
											$("#signup-form").css("display","none"); //hide the previous window
											$("#email_section").css("display","inline-block"); //display the email section
										}else{
											alert(data);
										}
									}
								});
							}else{
								$("#error_repass").html("Passwords do not match");
							}
						}
					}
				}
			}else{
				$("#error_tnc").html("Agree to the Terms and Conditions to continue");
			}
		}
	});

	$("#pass").keyup(function(event) //suggests the password structure as soon as the key is pressed
	{								//following are the password validation conditions
		$("#error_pass").html("");
		var pass=$("#pass").val();
		$("#pass_suggest").css("display","inline-block");
		if(pass.length >= 8)
		{
			$("#total_char").css("color","green");
			$("#total_char i").addClass('fa-check-circle');
		}else{
			$("#total_char").css("color","red");
			$("#total_char i").removeClass('fa-check-circle');
		}
		if(pass.match(/^\S*$/))
		{
			$("#white_space").css("color","green");
			$("#white_space i").addClass('fa-check-circle');
		}else{
			$("#white_space").css("color","red");
			$("#white_space i").removeClass('fa-check-circle');
		}

		if(pass.match(/\d/))
		{
			$("#pass_num").css("color","green");
			$("#pass_num i").addClass('fa-check-circle');
		}
		else{
			$("#pass_num").css("color","red");
			$("#pass_num i").removeClass('fa-check-circle');
		}
	});

	$("#show_pass").click(function() //shows the password when show key is clicked
	{
		if($("#pass").attr("type")=="password")
		{
			$("#pass").attr("type","text");
			$(this).html("hide");
		}
		else{
			$("#pass").attr("type","password");
			$(this).html("show");
		}
	});
	$("#show_repass").click(function()
	{
		if($("#repass").attr("type")=="password")
		{
			$("#repass").attr("type","text");
			$(this).html("hide");
		}
		else{
			$("#repass").attr("type","password");
			$(this).html("show");
		}
	});

	$("#send_otp_btn").click(function() //submits email when clicked and sends an ajax request
	{									//to check whether the email exists. sends otp if email doesn't already exists
		var email=$("#email").val();
		if(email!="")
		{
			if(email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i)) //email validation condition
			{
				$("#overlay2").css("display","block");
				$.ajax({ //ajax request, to pass the email to php page
					type:"post",
					url:"userSignupPHP.php", //sends email address to 'userSignup.php' page
					data:{email_addr:email},
					success:function(data)
					{
						if(data=="OTP sent")
						{
							$("#otp_section").css("display","inline-block"); //otp section is displayed when email is sent successfully
							$("#resend_otp_btn").css("display","inline-block"); 
							$("#resend_message").html("OTP is sent to your email"); 
						}else{
							alert(data);
						}
						$("#overlay2").css("display","none");
					}
				});
			}else{
				$("#resend_message").html("Invalid Email");
			}
		}else{	
			$("#resend_message").html("Please enter your Email");
		}
	});
	
	$("#verify_otp_btn").click(function() //following function is executed when otp is submitted
	{
		var otp=$("#otp").val();
		var email_addr=$("#email").val();
		if(otp!="")
		{
			$.ajax({
				type:"post",
				url:"userSignupPHP.php", //ajax request to submit the OTP to this php page
				data:{verify_otp:otp,email:email_addr},
				success:function(data)
				{
					if(data=="email verified") //if  server responds with this message
					{							//redirect to  userProfile.php page
						window.location.href="userProfile.php";
					}else{
						alert(data);
					}
				}
			});
		}else{
			alert("Please enter the otp");
		}
	});
	$("#resend_otp_btn").click(function() //does the following when resend otp button is clicked
	{
		var email_addr=$("#email").val();
		var otp=true;
		$("#overlay2").css("display","block");
		$.ajax({ 
			type:"post",
			url:"userSignupPHP.php", //request the server to send new otp email
			data:{resend_otp:otp, eamil:email_addr},
			success:function(data)
			{
				if(data="OTP resent")
				{
					$("#resend_message").html("OTP resent to your email");
				}else{
					alert(data);
				}
				$("#overlay2").css("display","none");
			}
		});
	});
});
