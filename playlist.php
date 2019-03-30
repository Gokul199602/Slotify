<?php 
include("includes/includedFiles.php"); 
if (isset($_GET['id']))
{

  $playlistid = $_GET['id'];
}

else
{
	header("location:index.php");
}

$playlist = new Playlist($con,$playlistid);
$user = new User($con, $playlist->getId());
?>

<div class = "entityInfo">
	<div class = "leftSection">
		<div class = "playlistimage">
			<img src="assets/images/Icons/playlist.png">
		</div>
	</div>
	<div class = "rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner();?></p>
		<p><?php echo $playlist->getNumSongs();?> songs</p>
	<button class = 'delete' onclick = "deletePlaylist('<?php echo $playlistid; ?>')">DELETE PLAYLIST</button>
	</div>

	
</div>
 
<div class="tracklistContainer">
		<ul class = 'tracklist'>
			<?php 
				$songsIdArray = $playlist->getSongIds();
				$i = 1;
				foreach ($songsIdArray as $songsId) 
				{
					$playlistSong = new Song($con,$songsId);
					$songArtist = $playlistSong->getArtist();
					echo "<li class = 'tracklistRow'>
						<div class = 'trackCount'>
						<img class ='play' src = 'assets/images/icons/play1.png' onclick='setTrack(\"".$playlistSong->getId()."\",tempPlayList,true)'>
							<span class = 'trackNumber'>$i</span>
						</div>
						<div class = 'trackInfo'>
						<span class = 'trackName'>".$playlistSong->getTitle()."</span>
						<span class = 'artistName'>".$songArtist->getName()."</span>
						</div>

						<div class = 'trackOptions'>
							<input type = 'hidden' class = 'songId'  value = '".$playlistSong->getId()."'>
							<img class = 'trackOptionButton' src = 'assets/images/icons/more.png' onclick='
							showoptionsMenu(this)'>
						</div>
						<div class = 'trackDuration'>
							<span class = 'duration'>".$playlistSong->getDuration()."</span>
						</div>
					</li>";
					$i = $i + 1;
				}
			 ?>
		</ul>
	</div>
<script type="text/javascript">
	var tempSongId = '<?php echo json_encode($songsIdArray) ?>'
	tempPlayList = JSON.parse(tempSongId);
</script>

<nav class = "optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUserLoggerIn()); ?>
	<div class = "item" onclick = "removeFromPlaylist(this,'<?php echo $playlistid ?>')">delete from playlist</div>
</nav>




