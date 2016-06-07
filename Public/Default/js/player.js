var audio;
var isPlaying = false;
window.onload = function() {
	var playBtn = document.getElementById("song-play-btn");
	playBtn.onclick = playClick;
}

var playClick = function () {
	if (isPlaying) {
		stop();
	} else {
		resume();
	}
}

function play (url) {
	audio = new Audio(url);
	audio.play();
	var btn = document.getElementById("song-play-icon");
	btn.setAttribute("class", "glyphicon glyphicon-pause");
	isPlaying = true;
}

function stop () {
	audio.pause();
	var btn = document.getElementById("song-play-icon");
	btn.setAttribute("class", "glyphicon glyphicon-play"); 
	isPlaying = false;
}

function resume () {
	audio.play();
	var btn = document.getElementById("song-play-icon");
	btn.setAttribute("class", "glyphicon glyphicon-pause");
	isPlaying = true;
}