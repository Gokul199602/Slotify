<?php 
	include("includes/includedFiles.php"); 
	if(isset($_GET['id']))
	{
		$artistid = $_GET['id'];
	}
	else
	{	
		header("Location: index.php");
	}

	$artist = new Artist($con,$artistid);
 ?>

 <script>
 	
 function playcurrentSong()
 	{
 		setTrack(tempPlayList[0],tempPlayList,true);
 	}
 	
 </script>

 
 		<div class ="entityInfo borderBottom">
 			<div id = "centreSection">
 				<div class = "artistInfo">
 					<h1 class="artistsName"><?php echo $artist->getName(); ?></h1> 
 					<div class = "headerButtons">
 					<button class = "button green" onclick='playcurrentSong()'>PLAY</button>
 				</div>
 				</div>
 			</div>
 		</div>


 		<div class="tracklistContainer borderBottom">
 			<h2>SONGS</h2>
		<ul class = 'tracklist'>
			<?php 
				$songsIdArray = $artist->getSongIds();
				$i = 1;
				foreach ($songsIdArray as $songsId) 
				{
					if($i>5)
					{
						break;
					}
					$albumSong = new Song($con,$songsId);
					$albumArtist = $albumSong->getArtist();
					echo "<li class = 'tracklistRow'>
						<div class = 'trackCount'>
						<img class ='play' src = 'assets/images/icons/play1.png' onclick='setTrack(\"".$albumSong->getId()."\",tempPlayList,true)'>
							<span class = 'trackNumber'>$i</span>
						</div>
						<div class = 'trackInfo'>
						<span class = 'trackName'>".$albumSong->getTitle()."</span>
						<span class = 'artistName'>".$artist->getName()."</span>
						</div>

						<div class = 'trackOptions'>
							<input type = 'hidden' class = 'songId'  value = '".$albumSong->getId()."'>
							<img class = 'trackOptionButton' src = 'assets/images/icons/more.png' onclick='
							showoptionsMenu(this)'>
						</div>
						<div class = 'trackDuration'>
							<span class = 'duration'>".$albumSong->getDuration()."</span>
						</div>
					</li>";
					$i = $i + 1;
				}
			 ?>
			</ul>
			<script type="text/javascript">
				var tempSongId = '<?php echo json_encode($songsIdArray) ?>'
				tempPlayList = JSON.parse(tempSongId);
			</script>
		</div>


		<div class = "gridViewContainer borderBottom">
			<h2>ALBUMS</h2>
	<?php 
		$albumQuery = mysqli_query($con,"Select * from albums where artist = '$artistid'");
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

<nav class = "optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUserLoggerIn()); ?>
	<div class = "item">ITEM1</div>
	<div class = "item">ITEM2</div>
</nav>
