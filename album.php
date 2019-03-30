<?php 
include("includes/includedFiles.php"); 
if (isset($_GET['id']))
{

  $albumsId = $_GET['id'];
}

else
{
	header("location:index.php");
}

$album = new Album($con,$albumsId);
$artist = $album->getArtist();
?>

<div class = "entityInfo">
	<div class = "leftSection">
		<img src="<?php echo $album->getArtworkPath() ?>">
	</div>
	<div class = "rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>By <?php echo $artist->getName();?></p>
		<p><?php echo $album->getNumSongs();?> songs</p>
	</div>

	
</div>

<div class="tracklistContainer">
		<ul class = 'tracklist'>
			<?php 
				$songsIdArray = $album->getSongIds();
				$i = 1;
				foreach ($songsIdArray as $songsId) 
				{
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
	</div>
<script type="text/javascript">
	var tempSongId = '<?php echo json_encode($songsIdArray); ?>'
	tempPlayList = JSON.parse(tempSongId);
</script>

<nav class = "optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUserLoggerIn()); ?>
</nav>




