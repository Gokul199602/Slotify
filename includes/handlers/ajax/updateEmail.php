<?php 
	include("../../config.php");

	if(!isset($_POST['username']))
	{
		echo "Error: Username has not been passed";
	}
	if(isset($_POST['email']) && $_POST['email']!="")
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			echo "email is invalid";
			exit();
		}
		else
		{
		     $emailCheck = mysqli_query($con,"SELECT email FROM users WHERE username != '$username' AND email = '$email'");
		     if(mysqli_num_rows($emailCheck)>0)
		     {
		     	echo "Email is already in use";
		     	exit();		     
		     }
		     else
		     {
		     	$updateQuery = mysqli_query($con,"UPDATE users SET email = '$email' WHERE username = '$username'");
		     	echo "The username is successfully updated";
		     }
		}
	}
	else
	{
		echo "Please Enter the email";
	}




 ?>