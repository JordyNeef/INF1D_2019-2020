<!DOCTYPE html>

<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/videos.php'; ?>
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <link type="text/css" rel="stylesheet" href="stylesheet/index.css" />
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
    </head>
    <body onresize="checkOpenForResponsive();">
        <?php
        headerBar();
        navBar();
        ?>
        <!-- h1 niet zichtbaar op mobiel!!!!-->
        <h1>Populair</h1>
        <!--style moet nog aangepast voor inladen (niet scroll en al dat)-->
        <div class="topVideoContainer">
            <!--dit zijn placeholders-->
            <div class="video">
                <?php
//                frontvid()
                ?>
            </div>
            <div class="video">

            </div>
            <div class="video">

            </div>
        </div>
        <div class="CatagorieVideoLists">
            <h2> Subcategorie </h2>
            <!--style moet nog aangepast voor inladen (niet scroll en al dat)-->
            <div class="videoCategorie">
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
        <div class="CatagorieVideoLists">
            <h2> Subcategorie </h2>
            <!--style moet nog aangepast voor inladen (niet scroll en al dat)-->
            <div class="videoCategorie">
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
        <div class="footer">
            <p> Made by Niffo Productions 2019 <?php
                if (date("Y") != 2019) {
                    echo"-" . date("Y");
                }
                ?> &copy  </p>
            <p>NHL Stenden</p>
        </div>
    </body>
    <?php navScript();?>
</html>
