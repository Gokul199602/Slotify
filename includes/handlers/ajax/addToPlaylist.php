<?php 
include("../../config.php");
if(isset($_POST['playlistId'])&&isset($_POST['songId']))
{
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];
	$queryId = mysqli_query($con,"SELECT MAX(playlistorder) + 1 as playlistOrder FROM playlistsongs WHERE playlistid = '$playlistId'");
	$row = mysqli_fetch_array($queryId);
	$playlistOrder = $row['playlistOrder'];
	$insertQuery =mysqli_query($con,"INSERT INTO playlistsongs VALUES ('','$songId','$playlistId','$playlistOrder')");
}
 ?>