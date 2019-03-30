<?php

Class Artist{
private $con;
private $id;
public function __construct($con,$id)
{
	$this->con = $con;
	$this->id = $id;
}


public function getName()
{
	$artistId = $this->id;

	$artistQuery = mysqli_query($this->con,"SELECT * FROM artists where id = '$artistId'");
	$artist = mysqli_fetch_array($artistQuery);	
	return $artist['name'];
}

public function getId()
{
	return $this->id;
}

public function getSongIds()
{
	$queryId = mysqli_query($this->con,"Select id from songs where artist = '$this->id' ORDER BY albumOrder ASC");

	$array = array();

	while($row = mysqli_fetch_array($queryId))
	{
		array_push($array, $row['id']);
		
	}

	return $array;
}

}

 ?>
