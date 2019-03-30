<?php 
include("includes/includedFiles.php"); 
?>

<h1 class ="pageHeadingBig">THE PAGE YOU MIGHT LIKE</h1>

<div class = "gridViewContainer">
	<?php 
		$albumQuery = mysqli_query($con,"Select * from albums ORDER BY RAND() LIMIT 10");
		while($row =mysqli_fetch_array($albumQuery))
		{
			echo "<div class = 'gridViewItem'>
				<span role = 'link' tabindex='0' onclick = 'openPage(\"album.php?id=".$row['id']."\")'>
				<img src ='".$row['artworkPath']."'>
				<div class = 'gridInfo'>"
				.$row['title'].
			"</div>
			</span>
			</div>";
			
		}
	 ?>
</div>

				






			