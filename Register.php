<?php
include("includes/config.php");
include('includes/classes/Account.php');

$account = new Account($con);

include('includes/classes/Constants.php');

include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");

function getInputValue($name)
{
	if(isset($_POST[$name]))
	{
		echo $_POST[$name];
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Slotify!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>



<body>

	<?php 
		if(isset($_POST['registerBotton']))
		{
			echo "<script >
       $(document).ready(function()
		     {
			
				$('#loginForm').hide();
				$('#registerForm').show();
			
		      }
			);
	</script>";
		}
		else
		{
			echo "<script >
       $(document).ready(function()
		     {
			
				$('#loginForm').show();
				$('#registerForm').hide();
			
		      }
			);
	</script>";
		}
	?>
	

	<div id="background">
		<div id = "loginContainer">
		 	<div id = "inputContainer">
		 	<form id = "loginForm" action = "register.php" method="Post" name="register">
		 	<h2>This is login page</h2>
		 	<p>
		 		<?php echo $account->getError(Constants::$loginFailed)?>
		 		<label for="loginUsername">User Name</label>
		 		<input id ="loginUsername" name="loginUsername" type ="text" placeholder="Name" value = "<?php getInputValue('loginUsername')?>" required>
		 	</p>
		 	<p>
		 	<label for="loginPassword">Password</label>
		 	<input id ="loginPassword" name="loginPassword" type ="password" placeholder = "Enter Password" required>
		    </p>
		    <p>
		  	 <button type = "Submit" name="loginBotton">LOG IN</button>
		    </p>
		 	
		 <div class="hasAccountText">
		 	<span id = "hideLogin">Register if you dont have an account.</span>
		 </div>

		 </form>

		  <form id = "registerForm" action = "register.php" method="Post" name="register">
		 	<h2>Create your free Account</h2>
		 <p>
		 	<?php echo $account->getError(Constants::$usernameTaken);  ?>
		 	<?php echo $account->getError(Constants::$usernameCharactors);  ?>
		 	
		 	<label for="username">User Name</label>
		 	<input id ="username" name="username" type ="text" value = "<?php getInputValue('username')?>" placeholder="Name" required>
		 </p>
		 <p>
		 	<?php echo $account->getError(Constants:: $firstNameCharactors);  ?>
		 	<label for="firstName">First Name</label>
		 	<input id ="firstName" name="firstName" type ="text" placeholder="your firstname" value = "<?php getInputValue('firstName')?>" required>
		 </p>
		 <p>
		 	<?php echo $account->getError(Constants::$lastNameCharectors);  ?>
		 	<label for="lastName">Last Name</label>
		 	<input id ="lastName" name="lastName" type ="text" value = "<?php getInputValue('lastName')?>" placeholder="your lastName" required>
		 </p>
		 <p>
		 	<?php echo $account->getError(Constants::$emailTaken);  ?>
		 	<?php echo $account->getError(Constants::$emailsDoNotMatch);  ?>
		 	<?php echo $account->getError(Constants::$emailInvalid);  ?>
		 	<label for="email">Email<label>
		 	<input id ="email" name="email" type ="Email" value = "<?php getInputValue('email')?>" placeholder="abc@cde.com" required>
		 </p>
		  <p>
		 	<label for="email2">Confirm Email<label>
		 	<input id ="email2" name="email2" type ="Email" value = "<?php getInputValue('email2')?>" placeholder="abc@cde.com" required>
		 </p>
		 <p>
		 	<?php echo $account->getError(Constants::$passwordsCharectors);  ?>
		 	<?php echo $account->getError(Constants::$passwordNotAlphanumeric);  ?>
		 	<?php echo $account->getError(Constants::$passwordsDoNotMatch);  ?>
		 	<label for="password">Password</label>
		 	<input id ="password" name="password" type ="password"  placeholder = "Enter Password" required>
		  </p>
		  <p>
		 	<label for="password2">Confirm Password</label>
		 	<input id ="password2" name="password2" type ="password" placeholder = "Enter Password"  required>
		  </p>
		  <p>
		  	<button type = "Submit" name="registerBotton">SIGN UP</button>
		  </p>
		   <div class="hasAccountText">
		 	<span id = "hideRegister">Click here if you already have an account</span>
		 </div>
		 	
		 </form>
		 </div>

		 <div id="loginText">
		 	<h1>Enjoy Greate Music right now</h1>
		 	<h2>Listen to loads of music for free.</h2>
		 	<ul>
		 		<li>Discover the music you fall love with</li>
		 		<li>Create your own playlist</li>
		 		<li>Discover the music you fall love with</li>
		 		<li>Follow artists to keep upto date.</li>
		 	</ul>
		 </div>>
      
        </div>

	</div>
</body>
</html>