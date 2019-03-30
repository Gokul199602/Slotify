<?php 
include("includes/includedFiles.php"); 
 ?>

 <div class = "playlistsContainer">
 	<div class = "gridViewContainer">
 		<h2>PLAYLISTS</h2>
 		<div class = "buttonItems">
 			<button class = "button green" onclick = "createPlaylist()">NEW PLAYLIST</button>
 		</div>
 		<?php 
 		$username = $userLoggedIn->getUserLoggerIn();
		$playListQuery = mysqli_query($con,"Select * from playlists where owner = '$username'");
		while($row =mysqli_fetch_array($playListQuery))
		{
			$playlist = new Playlist($con,$row);
			echo "
			<div class = 'gridViewItem'>
					<div class = 'playlistimage'>
						<img src='assets/images/Icons/playlist.png' role = 'link' tabindex='0' 
						onclick = 'openPage(\"playlist.php?id=".$playlist->getId()."\")'>
					</div>
					<div class = 'gridInfo'>"
					.$playlist->getName().
					"</div>
			</div>";
			
		}
	 ?>
 	</div>

 </div>