var videoidtest;
function timestamp (url, videoid, gebruikerid){
    console.log(clickedVideo);
    videoidtest = videoid
        setInterval(function(){
            if(videoidtest >= 1){
                $.ajax({
                    method: "POST",
                    url: "config/sendtimestamp.php",
                    data: { timestamp: videotime, gebruikerid: gebruikerid, videoid: videoid}
                })
                .done(function( msg ) {
                });
                    console.log("set" + videotime);
            }
        }, 5000);
}

var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

console.log(tag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
var videotime = 0;
function onYouTubeIframeAPIReady() {
    console.log('testing');
player = new YT.Player('popup', {
    videoId: "videourl",
    events: {
    'onReady': onPlayerReady,
    'onStateChange': onPlayerStateChange
    }
});
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
event.target.playVideo();
function updateTime() {
    var oldTime = videotime;
    if(player && player.getCurrentTime) {
    videotime = player.getCurrentTime();
    // document.getElementById("time").innerHTML = videotime;
    }
    if(videotime !== oldTime) {
    onProgress(videotime);
    }
}
timeupdater = setInterval(updateTime, 100);
}

// when the time changes, this will be called.
function onProgress(currentTime) {
if(currentTime > 20) {
}
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
if (event.data == YT.PlayerState.PLAYING && !done) {
}
}
function stopVideo() {
}
