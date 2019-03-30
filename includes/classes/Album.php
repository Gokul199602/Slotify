<?php

Class Album{
private $con;
private $id;
private $artistworkPath;
private $title;
private $artist;
private $genre;

public function __construct($con,$id)
{
	$this->con = $con;
	$this->id = $id;

	$query = mysqli_query($this->con,"SELECT * FROM albums where id = '$this->id'");
	$album = mysqli_fetch_array($query);

	$this->title = $album['title'];
	$this->artistId = $album['artist'];
	$this->genre = $album['genre'];
	$this->artworkPath = $album['artworkPath'];
}


public function getTitle()
{	
	return $this->title;
}


public function getGenre()
{	
	return $this->genre;
}

public function getArtworkPath()
{	
	return $this->artworkPath;
}


public function getArtist()
{
	return new Artist($this->con,$this->artistId);
}

public function getNumSongs()
{
	$numquery = mysqli_query($this->con,"Select * from songs where album = '$this->id'");
	return mysqli_num_rows($numquery);
}

public function getSongIds()
{
	$queryId = mysqli_query($this->con,"Select id from songs where album = '$this->id' ORDER BY albumOrder ASC");

	$array = array();

	while($row = mysqli_fetch_array($queryId))
	{
		array_push($array, $row['id']);
		
	}

	return $array;
}


}
 ?>

