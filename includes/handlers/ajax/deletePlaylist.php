<?php 
include("../../config.php");
if(isset($_POST['playlistid']))
{
	$playlistid = $_POST['playlistid'];
	$playlistQuery = mysqli_query($con,"DELETE FROM playlists WHERE id = '$playlistid'");
	$playlistQuery = mysqli_query($con,"DELETE FROM playlistsongs WHERE playlistid = '$playlistid'");
}
 ?>
