var currentPlayList = [];
var tempPlayList = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = true;
var userLoggedIn;
var timer;

$(window).scroll(function()
{
	hideoptionsMenu();
});

$(document).click(function(click)
{
	var target = $(click.target);
	if(!target.hasClass('item')&& !target.hasClass('trackOptionButton'))
	{
		hideoptionsMenu();
	}
	
});

function logout()
{
	$.post("includes/handlers/ajax/logout.php",function()
		{
			location.reload();
		});
}

function updateEmailId(emailClass)
{
	var email = $("."+emailClass).val();
	$.post("includes/handlers/ajax/updateEmail.php",{email : email,username : userLoggedIn})
	.done(function(response){
		$("."+emailClass).nextAll(".message").text(response);
	});
}

function updatePassword(oldPasswordClass,newPasswordClass1,newPasswordClass2)
{
	var oldPassword = $("."+oldPasswordClass).val();
	var newPassword1 = $("."+newPasswordClass1).val();
	var newPassword2 = $("."+newPasswordClass2).val();
	$.post("includes/handlers/ajax/updatePassword.php",
		{oldPassword : oldPassword,
		newPassword1 : newPassword1,
		newPassword2 : newPassword2,
		username : userLoggedIn})
	.done(function(response){
		$("."+oldPasswordClass).nextAll(".message").text(response);
	});
}

$(document).on("change","select.playlist",function()
	{
		var select = $(this);
		var playlistId = select.val();
		var songId = select.prev(".songId").val();
		$.post("includes/handlers/ajax/addToPlaylist.php",{songId:songId,playlistId:playlistId})
		.done(function(error){
			hideoptionsMenu();
			if(error!="")
			{
				alert(error);
				return;
			}
			select.val("");
		});
	});




function openPage(url)
{
	if(timer != null)
	{
		clearTimeout(timer);
	}
	if(url.indexOf("?") == -1)
	{
		url = url + "?";
	}
	var urlEncode = encodeURI(url+"&userLoggedIn="+userLoggedIn);
	$("#mainContent").load(urlEncode);
	$("body").scrollTop(0);
	history.pushState(null,null,url);
}

function showoptionsMenu(button)
{
	var songId = $(button).prevAll(".songId").val();
	var menu = $(".optionsMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop();
    var elementOffset = $(button).offset().top;
    var top = elementOffset-scrollTop;

    var left = $(button).position().left;

    menu.css({"top":top+"px","left": left-menuWidth+"px","display":"inline"});
}

function hideoptionsMenu()
{
	var menu = $('.optionsMenu');
	if(menu.css("display")!="none")
	{
		menu.css("display","none");
	}
}


function createPlaylist()
{
	console.log(userLoggedIn);
	var popup = prompt("Please Enter the name of playlist");
	if(popup!=null)
	{
		$.post("includes/handlers/ajax/createPlaylist.php",{name : popup, username : userLoggedIn})
		.done(function(error){
			if(error!="")
			{
				alert(error);
				return;
			}
			openPage('yourMusic.php');
		});

	}
}

function removeFromPlaylist(button, playlistId)
{
	var songId = $(button).prevAll(".songId").val();
	var prompt = confirm("are u sure you want to delete song");
	if(prompt)
	{
		$.post("includes/handlers/ajax/removeFromPlaylist.php",{playlistId : playlistId,songId ,songId:songId})
		.done(function(error){
			if(error!="")
			{
				alert(error);
				return;
			}
			openPage('playlist.php?id='+playlistId);
		});
	}

}

function deletePlaylist(playlistid)
{
	var prompt = confirm("are u sure you want to delete playlist");
	if(prompt)
	{
		$.post("includes/handlers/ajax/deletePlaylist.php",{playlistid : playlistid})
		.done(function(error){
			if(error!="")
			{
				alert(error);
				return;
			}
			openPage('yourMusic.php');
		});
	}
}

function formatTime(seconds)
{
	var time = Math.round(seconds);
	var minutes = Math.floor(time/60);
	var seconds = time - (minutes*60);
	if(seconds<10)
	{
		extraZero = "0";
	}
	else
	{
		extraZero = "";
	}
	return minutes + ":"+extraZero+seconds;
}

function updateTimeProgressBar(audio)
{
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration-audio.currentTime));
	var progress = audio.currentTime/audio.duration*100;
	$(".progress").css("width", progress+"%");
}

function updateVolumeProgressBar(audio)
{
	var volume = audio.volume*100;
	$("#progress2").css("width", volume+"%")
}


 function playcurrentSong()
 	{
 		setTrack(tempPlayList[0],tempPlayList,true);
 	}

function Audio()
{
	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("canplay", function() {
		duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});
	this.audio.addEventListener("timeupdate", function(){
		if(this.duration)
		{
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange",function(){
		updateVolumeProgressBar(this);
	});

	this.audio.addEventListener("ended",function()
		{
			nextSong();
		});

	this.setTrack = function(track)
	{
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function()
	{
		this.audio.play();
	}

	this.pause = function()
	{
		this.audio.pause();
	}
	this.setTime = function(seconds)
	{
		this.audio.currentTime = seconds;
	}



}
