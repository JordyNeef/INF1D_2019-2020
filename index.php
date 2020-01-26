<!DOCTYPE html>

<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/video_thumbnail.php'; ?>
        <?php require 'config/videos.php'; ?>
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <link type="text/css" rel="stylesheet" href="stylesheet/index.css" />
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
    </head>
    <body onload="scrollTopVideos();" onresize="checkOpenForResponsive();" >
        <?php
        headerBar();
        navBar();
        ?>
        <!-- h1 niet zichtbaar op mobiel!!!!-->
        <h1>Populair</h1>
        <!--style moet nog aangepast voor inladen (niet scroll en al dat)-->
        <div onwheel="scrollHorizantal(event,'topVideoContainer', 0)" class="topVideoContainer">
            <!--dit zijn placeholders-->
            <?php
//            frontvid();

            frontvidthumb();
            ?>
            <div onclick="returnToStart();" id="back">
                <p>&#8634;</p>
            </div>
        </div>
        <div class="CatagorieVideoLists">
            <h2> Subcategorie </h2>
            <!--style moet nog aangepast voor inladen (niet scroll en al dat)-->
            <div onwheel="scrollHorizantal(event,'videoCategorie', 0)" class="videoCategorie">
                <div class="video">

                </div>
                <div class="video">

                </div>
                <div class="video">

                </div>
                <div class="video">

                </div>
            </div>
        </div>
        <div  class="CatagorieVideoLists">
            <h2> Subcategorie </h2>
            <!--style moet nog aangepast voor inladen (niet scroll en al dat)-->
            <div onwheel="scrollHorizantal(event,'videoCategorie', 1)" class="videoCategorie">
                <div class="video">

                </div>
                <div class="video">

                </div>
                <div class="video">

                </div>
                <div class="video">

                </div>
                <div class="video">

                </div>
            </div>

        </div>
        <!--niet zichtbaar als je niet op filmpje klikt-->
        <div id="frame" >
            <div id="popupHouder">
                <div class="navCloseButton" onclick="closePopup()">&#10005;</div> 
                <div id="info">
                    <!--scr wordt met javascript gezet-->
                    <iframe width="100%" height="100%" id="popup" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    <!--video info wordt er ook met javascript ingezet-->
                    <h4 id="titel"></h4>
                    <p id="beschrijving"></p>
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
