<?php

Class Song{
private $con;
private $id;
private $mysqli_data;
private $title;
private $artistId;
private $albumId;
private $genre;
private $duration;
private $path;
private $hi;


public function __construct($con,$id)
{
	$this->con = $con;
	$this->id = $id;

	$query = mysqli_query($this->con,"SELECT * FROM songs WHERE id = '$this->id'");
	$mysqli_data = mysqli_fetch_array($query);

	$this->title = $mysqli_data['title'];
	$this->artistId = $mysqli_data['artist'];
	$this->albumId = $mysqli_data['album'];
	$this->genre = $mysqli_data['genre'];
	$this->duration = $mysqli_data['duration'];
	$this->path = $mysqli_data['path'];
}

public function getTitle()
{
	echo $this->hi;
	return $this->title; 
}

public function getId()
{
	return $this->id;
}

public function getArtist()
{
	return new Artist($this->con,$this->artistId);
}

public function getAlbum()
{
	return new Album($this->con, $this->albumId);
}

public function getGenre()
{
	return $this->genre;
}

public function getMysqliData()
{
	return $this->mysqli_data;
}

public function getPath()
{
	return $this->path;
}

public function getDuration()
{
	return $this->duration;
}
}
 ?>

