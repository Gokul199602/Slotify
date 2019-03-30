<?php 
include("includes/includedFiles.php"); 

	if(isset($_GET['term']))
	{
		$term = urldecode(($_GET['term']));
	}
	else
	{
		$term = "";
	}
 ?>

 <div class = "searchContainer">
 	<h1>What you want to search for</h1>
 	<input type="text" class = "searchInput" placeholder="search what ever you want" value="<?php echo $term;?>" onfocus="this.value=this.value">

 	
 </div>

 <script>
 	$('.searchInput').focus();
 		$(function()
 		{
 	 			$(".searchInput").keyup(function(){

 				clearTimeout(timer);

 				timer = setTimeout(function(){
 					var val = $(".searchInput").val();
 					openPage("search.php?term="+val);
 	 			},2000);

 		})
 	})

 </script>

<?php if($term == "") exit();?>
 <div class="tracklistContainer borderBottom">
 			<h2>SONGS</h2>
		<ul class = 'tracklist'>
			<?php 
				$songsQuery = mysqli_query($con,"SELECT * FROM songs WHERE title LIKE '$term%' LIMIT 10");
				$i = 1;

				if(mysqli_num_rows($songsQuery)==0)
				{
					echo"<span class = 'noResultFound'>No result was found for ".$term."</span>";
				}
				$songsIdArray = array();
				while ($row = mysqli_fetch_array($songsQuery)) 
				{
					if($i>15)
					{
						break;
					}
					array_push($songsIdArray, $row['id']);
					$albumSong = new Song($con,$row['id']);
					$albumArtist = $albumSong->getArtist();
					echo "<li class = 'tracklistRow'>
						<div class = 'trackCount'>
						<img class ='play' src = 'assets/images/icons/play1.png' onclick='setTrack(\"".$albumSong->getId()."\",tempPlayList,true)'>
							<span class = 'trackNumber'>$i</span>
						</div>
						<div class = 'trackInfo'>
						<span class = 'trackName'>".$albumSong->getTitle()."</span>
						<span class = 'artistName'>".$albumArtist->getName()."</span>
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

    <div class = "artistContainer borderBottom">
    	<h2>Artists</h2>
    	<?php 
    		$artistQuery = mysqli_query($con,"SELECT * FROM artists where name LIKE '$term%' LIMIT 10");
    		$i = 1;
    		if(mysqli_num_rows($artistQuery)==0)
				{
					echo"<span class = 'noResultFound'>No result was found for ".$term."</span>";
				}
			while($row = mysqli_fetch_array($artistQuery))
			{
				$artistFound = new Artist($con,$row['id']);
				echo "<div class = searchResultRow>
					<div class = artistNames>
						<span role='link' tabindex = '0' onclick = 'openPage(\"artist.php?id=".$artistFound->getId()."\")'>
						"
						.$artistFound->getName().
						"
						</span>
					</div>
				</div>";
			}
    	 ?>
    </div>

    <div class = "gridViewContainer borderBottom">
			<h2>ALBUMS</h2>
	<?php 
		$albumQuery = mysqli_query($con,"Select * from albums where title LIKE '$term%'");
		if(mysqli_num_rows($albumQuery)==0)
				{
					echo"<span class = 'noResultFound'>No result was found for ".$term."</span>";
				}
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
	 <nav class = "optionsMenu">
		<input type="hidden" class="songId">
		<?php echo Playlist::getPlaylistDropdown($con,$userLoggedIn->getUserLoggerIn()); ?>
		<div class = "item">ITEM1</div>
		<div class = "item">ITEM2</div>
	</nav>



