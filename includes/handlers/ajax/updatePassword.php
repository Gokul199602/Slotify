<?php 
	include("../../config.php");

	if(!isset($_POST['username']))
	{
		echo "Error: Username has not been passed";
	}
	
	if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2']))
	{
		echo "Passsword has not been set.";
		exit();
	}

	if(isset($_POST['oldPassword'])=="" || isset($_POST['newPassword1'])=="" || isset($_POST['newPassword2'])=="")
	{
		echo "The password is null";
		exit();
	}
	$username = $_POST['username'];
	$oldPassword = $_POST['oldPassword'];
	$newPassword1 = $_POST['newPassword1'];
	$newPassword2 = $_POST['newPassword2'];

	$oldMD5 = MD5($oldPassword);
	$passwordCheck = mysqli_query($con,"SELECT * FROM users WHERE username = '$username' AND password = '$oldMD5'");
	if(mysqli_num_rows($passwordCheck)!=1)
	{
		echo "Enter correct password";
		exit();
	}

	if($newPassword1!=$newPassword2)
	{
		echo "Password does not match";
		exit();
	}

	if(preg_match('/[^A-Za-z0-9]/', $newPassword1))
	{
		echo "Your password should only contain letters or numbers";
		exit();
	}
	if(strlen($newPassword1)>30 || strlen($newPassword1)<5)
	{
		echo "your Password charectors should be between 5 and 30";
		exit();
	}

	$newMD5 = MD5($newPassword1);

	$updatedPassword = mysqli_query($con,"UPDATE users SET password = '$newMD5'");
	echo "Update successful";
 ?>