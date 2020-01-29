    <?php
      $connect = mysqli_connect("localhost", "root", "", "niffoflix");
      // vraagd timestamp op vanuit de database
      $sql = "SELECT tijdstip FROM kijksessie WHERE gebruikerid = ? && videoid = ?";
      $userid = 1;
      $videoid = 1;
      if($stmt = mysqli_prepare($connect, $sql)){
        mysqli_stmt_bind_param($stmt, "ii", $userid, $videoid);
        if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_bind_result($stmt, $timestampdb);
          mysqli_stmt_fetch($stmt);
          echo $timestampdb;
          $url = "//www.youtube.com/embed/M7lc1UVf-VE?enablejsapi=1&start=" . $timestampdb;
          echo $url;
        }
        else{
          echo mysqli_error($connect);
        }
      }
      else{
        echo mysqli_error($connect);
      }
      mysqli_stmt_close($stmt);
    ?>
<script>
// 2. This code loads the IFrame Player API code asynchronously.
                    var tag = document.createElement('script');

                    tag.src = "https://www.youtube.com/iframe_api";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                    // 3. This function creates an <iframe> (and YouTube player)
                    //    after the API code downloads.
                    var player;
                    var videotime;
                    function onYouTubeIframeAPIReady() {
                    player = new YT.Player('popup', {
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
                        document.getElementById("time").innerHTML = videotime;
                        }
                        if(videotime !== oldTime) {
                        onProgress(videotime);
                        }
                    }
                    timeupdater = setInterval(updateTime, 100);
                    }
                    function onPlayerStateChange(event) {
                    }

                    setInterval(function(){
                    if(clickedVideo == true){
                    $.ajax({
                    method: "POST",
                    url: "config/sendtimestamp.php",
                    data: { timestamp: videotime, videoid: videoid, gebruikerid: gebruikerid}
                    })
                    .done(function( msg ) {
                        console.log("send timestamp = " + videotime + " to the database");
                    });
                    console.log("set");
                    }
                    }, 5000);
</script>
