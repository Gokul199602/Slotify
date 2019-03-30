<?php

function sanitizeFormUsername($inputText)
{
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ","", $inputText);
    return $inputText;
}

function sanitizeFormEmail($inputText)
{
	$inputText = str_replace(" ","", $inputText);
    return $inputText;
}

function sanitizePassword($inputText)
{
	$inputText = strip_tags($inputText);
    return $inputText;
}
function sanitizeFormString($inputText)
{
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ","", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}


if(isset($_POST['registerBotton']))
{
	//register button has been pressed.
     $username = sanitizeFormUsername($_POST['username']);
     $firstName = sanitizeFormString($_POST['firstName']);
     $lastName = sanitizeFormString($_POST['lastName']);
	 $email = sanitizeFormEmail($_POST['email']);
	 $email1 = sanitizeFormEmail($_POST['email2']);
	 $password = sanitizePassword($_POST['password']);
	 $password1 = sanitizePassword($_POST['password2']);
	 
	$wasSuccesful =  $account->register($username, $firstName,$lastName, $email, $email1,$password, $password1);

 if($wasSuccesful==true)
    {
    	$_SESSION['userLoggedIn'] = $username;
    	header("Location:index.php");
    }
}


?>