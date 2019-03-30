<?php 
include("includes/includedFiles.php");
 ?>

 <div class = 'entityInfo'>
 	<div class = 'centreSection'>
 		<div class = 'userInfo'>
 			<h1><?php echo $userLoggedIn->getUserFullName() ?></h1>
 		</div>
 	</div>
 	<div class = "buttonItems">
 		<button class = "button" onclick = "openPage('userDetails.php')">USER DETAILS</button>
 		<button class = "button" onclick = "logout()">LOGOUT</button>
 	</div>
 </div>