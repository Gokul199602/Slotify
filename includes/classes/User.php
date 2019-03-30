<?php

Class User{
private $con;
private $username;
public function __construct($con,$username)
{
	$this->con = $con;
	$this->username = $username;
}

public function getUserLoggerIn()
{
	return $this->username;
}

public function getEmailId()
{

	$query = mysqli_query($this->con, "SELECT email FROM users WHERE username = '$this->username'");
	$row = mysqli_fetch_array($query);
	return $row['email'];
}

public function getUserFullName()
{
	$query = mysqli_query($this->con, "SELECT CONCAT(firstName,' ',lastName) as 'name' FROM users where username = '$this->username'");
	$row = mysqli_fetch_array($query);
	return $row['name'];
}

}