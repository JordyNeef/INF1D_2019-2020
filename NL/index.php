<!DOCTYPE html>

<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/categorie_video.php'; ?>
        <?php require 'config/video_thumbnail.php'; ?>
        <?php require 'config/videos.php'; ?>
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <link type="text/css" rel="stylesheet" href="stylesheet/index.css" />
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="config/ytapi.js"></script>
        <script src="config/likesystem.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    </head>
    <body onload="scrollTopVideos();" onresize="checkOpenForResponsive();" >
        <?php
        headerBar();
        navBar();
        ?>
        <!-- h1 niet zichtbaar op mobiel!!!!-->
        <h1>Populair</h1>
        <div class="topVideoContainer">
            <?php
//            frontvid();

            frontvidthumb();
            ?>
            <div onclick="returnToStart();" id="back">
                <p>&#8634;</p>
            </div>
        </div>
        <?php
            categorieVideos();
        ?>
        <!--niet zichtbaar als je niet op filmpje klikt-->
        <div id="frame" >
            <div id="popupHouder">
                <div class="navCloseButton" onclick="closePopup()">&#10005;</div> 
                <div id="info">
                    <!--scr wordt met javascript gezet-->
                    <div id="popup"></div>
                    <!--video info wordt er ook met javascript ingezet-->
                    <h4 id="titel"></h4>
                    <p id="beschrijving"></p>
                    <div id="nifforating">
                        <div id="nifforatingup">
                            <button type="button" id="like" name="beoordeling" value="1"><img src="img/upniffo-unclicked.png" alt="upniffo" id="upniffo"></button>
                            <div id="likes"><?php echo $likes ?></div>
                        </div>
                        <div id="nifforatingdown">
                            <button type="button" id="dislike" name="beoordeling" value="0"><img id="downniffo" src="img/downniffo-unclicked.png" alt="downniffo"></button>
                            <div id="dislikes"><?php echo $dislikes ?></div>
                        </div>
                        <p id="videoid"></p>
                    </div>
                    </script>
                </div>
            </div>
        </div>
        <div class="footer">
            <p> Made by Niffo Productions 2019 <?php
                if (date("Y") != 2019) {
                    echo"-" . date("Y");
                }
                ?> &copy  </p>
            <p>NHL Stenden</p>
        </div>
    </body>
    <?php navScript(); ?>
</html>
