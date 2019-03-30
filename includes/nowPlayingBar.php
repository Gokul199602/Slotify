
<?php

$songQuery = mysqli_query($con,"SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while ($row = mysqli_fetch_array($songQuery) )
{
	array_push($resultArray, $row['id']);	
}
$jsonArray = json_encode($resultArray);
 ?>

 <script>
 $(document).ready(function()
		     {
			
				var newPlayList = <?php echo $jsonArray; ?>;
		 		audioElement = new Audio();
		 		setTrack(newPlayList[0],newPlayList,false);
		 		updateVolumeProgressBar(audioElement.audio);
		 		$('#nowPlayingBarContainer').on('mousedown touchstart mousemove touchmove',function(e){
		 			e.preventDefault();
		 		});

		 		$(".progressBar").mousedown(function(){
		 			mouseDown = true;
		 		});
		 		$(".progressBar").mousemove(function(e){
		 			if(mouseDown == true)
		 			{
		 				timeFromOffset(e, this);
		 			}
		 		});

		 		$(".progressBar").mouseup(function(e){
		 				timeFromOffset(e, this);
		 		});

		 		$(document).mouseup(function(e){
		 				mouseDown=false;
		 		});

		 		$("#progressBar2").mousedown(function(){
		 			mouseDown = true;
		 		});
		 		$("#progressBar2").mousemove(function(e){
		 			if(mouseDown == true)
		 			{
		 				var percentage = e.offsetX/$(this).width();
		 				if(percentage<=1&&percentage>=0)
		 				{
		 					audioElement.audio.volume=percentage;
		 				}
		 			}
		 		});

		 		$("#progressBar2").mouseup(function(e){
		 				if(mouseDown == true)
		 			{
		 				var percentage = e.offsetX/$(this).width();
		 				if(percentage<=1&&percentage>=0)
		 				{
		 					audioElement.audio.volume=percentage;
		 				}
		 			}
		 		});

		 		$(document).mouseup(function(e){
		 				mouseDown=false;
		 		});
			
		      }
			);
 	function timeFromOffset(mouse,progressBar)
 	{
 		var percentage = mouse.offsetX / $(progressBar).width()*100;
 		var seconds = audioElement.audio.duration*(percentage/100);
 		audioElement.setTime(seconds);
 	}

 	function setRepeat()
 	{
 		repeat =!repeat;
 		var imageName = repeat ? "repeatActive.png":"repeat.png";
 		$(".controlButton.repeat img").attr("src","assets/images/Icons/"+imageName);
 	}

 	function setMuted()
 	{
 		audioElement.audio.muted =!audioElement.audio.muted;
 		var imageName = audioElement.audio.muted ? "muted.png":"Sound.png";
 		$(".controlButton.volume img").attr("src","assets/images/Icons/"+imageName);
 	}

 	function setShuffle()
 	{
 		shuffle =!shuffle;
  		var imageName = shuffle ? "shuffle.png":"shuffleActive.png";
 		$(".controlButton.shuffle img").attr("src","assets/images/Icons/"+imageName);
 		if(shuffle==true)
 		{
 			//activate playlist and shuffle the song
 			shuffleArray(shufflePlaylist);
 			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
 		}
 		else
 		{
 			//deactivate the shuffle
 			currentIndex = currentPlayList.indexOf(audioElement.currentlyPlaying.id);
 		}
 	}

 	function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
}

 	function prevSong()
 	{
 		if(audioElement.audio.currentTime>=3||currentIndex==0)
 		{
 			audioElement.setTime(0);
 		}
 		else
 		{
 			currentIndex = currentIndex - 1;
 			setTrack(currentPlayList[currentIndex],currentPlayList,true);
 		}
 	}

 	function nextSong(){
 		if(repeat == true)
 		{
 			audioElement.setTime(0);
 			playSong();
 			return;
 		}
 		if(currentIndex == currentPlayList.length-1)
 		{
 			currentIndex = 0;
 		}
 		else
 		{
 			currentIndex++;
 		}
 		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlayList[currentIndex];
 		setTrack (trackToPlay, currentPlayList,true);
 	}


 		function setTrack(trackId,newPlayList,play)
 		{
 			if(newPlayList != currentPlayList)
 			{
 				currentPlayList = newPlayList;
 				shufflePlaylist = currentPlayList.slice();
 				shuffleArray(shufflePlaylist);
 			}
 			if(shuffle==true){
 				currentIndex = shufflePlaylist.indexOf(trackId);
 			}
 			else
 			{
 			currentIndex = currentPlayList.indexOf(trackId);
 			}
 			pauseSong();
 			$.post("includes/handlers/ajax/getSongJson.php",{songId: trackId},function(data)
 			{
  				var track = JSON.parse(data);
 				$("#trackInfo .trackName").text(track.title);
 				$.post("includes/handlers/ajax/getArtistJson.php",{artistId : track.artist},function(data)
 				{
 					var artist = JSON.parse(data);
 					$("#trackInfo .artistName").text(artist.name);
 					$("#trackInfo .artistName").attr("onclick","openPage('artist.php?id="+artist.id+"')");
 				});

 				$.post("includes/handlers/ajax/getArtworkJson.php",{albumId : track.album},function(data)
 				{
 					var album = JSON.parse(data);
 					$(".albumLink img").attr("src",album.artworkPath);
 					$(".albumLink img").attr("onclick","openPage('album.php?id="+album.id+"')");
 				});
 				audioElement.setTrack(track);
 				if(play)
 			{
 				playSong();
 		    }

 			});
 			

 		}

 		function playSong()
 	 	{
 	 		if(audioElement.audio.currentTime == 0)
 	 		{
 	 			$.post("includes/handlers/ajax/updatePlay.php",{songId : audioElement.currentlyPlaying.id });
 	 		}	
  	 		$(".controlButton.play").hide();
 	 		$(".controlButton.pause").show();
 	 		audioElement.play();
 	 	}

 	 	function pauseSong()
 	 	{
 	 		$(".controlButton.play").show();
 	 		$(".controlButton.pause").hide();
 	 		audioElement.pause();
 	 	}
 </script>




<div id ='nowPlayingBar'>
			<div id ="nowPlayingLeft">
				<div id="content">
					<span role='link' tabindex="0" class= "albumLink">
						<img src="" class="albumArtwork">
					</span>
				</div>
				<div id ="trackInfo">
					<span role='link' tabindex="0" class = 'trackName'></span>
					
				    <span role='link' tabindex="0" class='artistName'></span>
				</div>
				
			</div>

			<div id = "nowPlayingCenter">
				<div class="content playerControlls">
					<div class="buttons">
						<button class="controlButton shuffle" title="Shuffle" onclick = "setShuffle()">
							<img src="assets/images/Icons/shuffle.png" alt ="Shuffle">
						</button>
						<button class="controlButton previous" title="Previous" onclick="prevSong()">
							<img src="assets/images/Icons/previous.png" alt ="previous">
						</button>
						<button class="controlButton play" title="Play" onclick="playSong()">
							<img src="assets/images/Icons/play.png" alt ="Shuffle">
						</button>
						<button class="controlButton pause" title="Pause" style="display: none;" onclick="pauseSong()">
							<img src="assets/images/Icons/pause.png" alt ="pause">
						</button>
						<button class="controlButton next" title="Next" onclick = "nextSong()">
							<img src="assets/images/Icons/next.png" alt ="next">
						</button>
						<button class="controlButton repeat" title="Repeat" onclick = "setRepeat()">
							<img src="assets/images/Icons/repeat.png" alt ="Shuffle">
						</button>
					</div>

					<div class="playBackBar">
						<span class="progressTime current">0.00</span>
						<div class="progressBar">
							<div class = "progressBarBg">
								<div class = "progress"></div>
							</div>
						</div>
						<span class = 'progressTime remaining'>0.00</span>
					</div>
					
				</div>
			</div>

			<div id = "nowPlayingRight">
				<div class = 'volumeBar'>
					<button class = 'controlButton volume' title = 'Volume Button' onclick = "setMuted()">
						<img src="assets/images/Icons/Sound.png" alt='volume'>
					</button>
					<div id="progressBar2">
							<div id = "progressBarBg2">
								<div id = "progress2"></div>
							</div>
					</div>

				</div>
			</div>
		</div>