<?php
	ob_start();
	session_start();

	$timezone = date_default_timezone_set("Asia/Calcutta");

	$con = mysqli_connect("3.23.178.115","root","Flatron12!","slotify");

	if(mysqli_connect_errno())
	{
		echo "failed to connect".mysqli_connect_errno();
	}

?>