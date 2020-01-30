<script type="text/javascript">
    var likestotal = <?php echo $likes?>;
    var dislikestotal = <?php echo $dislikes ?>;
</script>
<?php
session_start();
//checkt of je ingelogd bent
if (isset($_SESSION["login"])) {
    //sessies definen
    $id = $_SESSION["ID"];
    $usernamesession = $_SESSION["username"];
    $admin = $_SESSION["admin"];
    $proefversie = $_SESSION["proefversie"];
    $profilepic = $_SESSION["profilepic"];
    $email = $_SESSION["email"];
} else {
    header("location:login.php");
}
function headerBar() {
    ?>
    <div class='header'>
        <div class="navOpenButton" onclick="navOpen();">
            <div class="navStreep"></div>
            <div class="navStreep"></div>
            <div class="navStreep"></div>
        </div>
        <div class="titleAndAccountButton">
            <div class="accountButton">
                <?php $profile_avatar = "../img/avatar/" . $_SESSION["profilepic"]; ?>
                <?php if (isset($_SESSION["profilepic"])) { ?>
                    <img class='profileimg' src= '<?php echo $profile_avatar; ?>' alt="account icoontje">
                    <?php
                } else {
                    echo "<img class='profileimg' src='img/avatar/account.png' alt='account icoontje'>";
                }
                ?>
                <div class="dropdown-content">
                    <a href="accountsettings.php">Account settings</a>
                    <?php
                    if ($_SESSION['admin'] == 1) {
                        echo"<a href='videotoevoegen.php'>Add a video</a>";
                        echo"<a href='videowijzigen.php'>Edit a video</a>";
                        echo"<a href='admintoewijzen.php'>Assign admin</a>";
                    }
                    ?>
                    <a href="config/logout.php">Logout</a>
                </div>
            </div>
            <div class="title">
                <a href="index.php"><img src="img/niffoflix_Logo.png" alt="logo van niffoflix"></a>
            </div>
        </div>
    </div>
    <?php
}

function navBar() {
    require 'conn.php';
    ?>
    <div id="navBar">
        <div class="navCloseButton"  onclick="navClose();">&#10005;</div>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="Get"> 
            <input class="searchInput" type="text" name="searchbar" placeholder="Search...">
        </form>  
        <?php
        //select 10 random categorien uit de database en plaats deze in de navbar: veranderd elke keer dat je hem herlaad
        $categorieQeury = "SELECT naam FROM categorie 
                            WHERE categorieid IN (SELECT categorieid 
                            FROM video_categorie)
                            ORDER BY RAND() LIMIT 10;";
        if ($categorieStmt = mysqli_prepare($conn, $categorieQeury)) {
            mysqli_execute($categorieStmt);
            mysqli_stmt_bind_result($categorieStmt, $categorieNaam);
            mysqli_stmt_store_result($categorieStmt);
            echo '<!--vul hier catergorieen in-->';
            while (mysqli_stmt_fetch($categorieStmt)) {
                echo '
        <a class="navText" href="index.php?naam=' . $categorieNaam . '">' . $categorieNaam . '</a>';
            }
            echo '</div>';
        }
        ?>
        <div id="transparentFakeContainer" onclick="navClose();"></div>
        <?php
    }

    function navScript() {
        ?>
        <script type="text/javascript">
            var w = window.innerWidth
                    || document.documentElement.clientWidth
                    || document.body.clientWidth;
            var navText = document.getElementsByClassName("navText");
            var open = false;
            var clickedVideo = false;

            //    unqoute dit om de breede van de website te zien:
            //    alert("Browser inner window width: " + w + ".");

            //check de groote van de website

            function checkWidth() {
                w = window.innerWidth
                        || document.documentElement.clientWidth
                        || document.body.clientWidth;
                return w;
            }

            //    veranderd de navbar van mobile naar computer en terug
            function checkOpenForResponsive() {
                if (open === true) {
                    navOpen();
                }
            }

            //open de navbar
            function navOpen() {
                checkWidth();
                //als de grote groter is dan 570px is de navbar 250px groot
                if (w > 415) {
                    document.getElementById("navBar").style.width = "250px";
                    document.getElementById("transparentFakeContainer").style.width = "calc(100% - 250px)";
                    for (i = 0; i < navText.length; i++) {
                        navText[i].style.width = "250px";
                    }

                } else {
                    //anders is hij zo breed als de website zelf
                    for (i = 0; i < navText.length; i++) {
                        navText[i].style.width = w + "px";
                    }
                    document.getElementById("navBar").style.width = w + "px";
                    document.getElementById("transparentFakeContainer").style.width = "0px";
                }
                open = true;
            }

            //    close de navbar 
            function navClose() {
                document.getElementById("navBar").style.width = "0px";
                document.getElementById("navBar").style.display = "hidden";
                document.getElementById("transparentFakeContainer").style.width = "0px";
                open = false;
            }

            //            open video popup
            //            
            function popup(playback, videoTitel, besch, videoid, gebruikerid, likes, dislikes, admin) {
                var currenttime;
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "config/gettimestamp.php",
                    data: {gebruikerid: gebruikerid, videoid: videoid},
                    success: function (data, succes) {
                        currenttime = data["timestamp"];
                        console.log(currenttime);
                        document.getElementById("popup").src = "https://www.youtube.com/embed/" + playback + "?enablejsapi=1&origin=http%3A%2F%2Flocalhost&widgetid=1&start=" + currenttime;
                    }
                });
                console.log(gebruikerid);
                if(admin === '1'){
                    document.getElementById("videoId").innerHTML = "videoid = " + videoid;
                }
                document.getElementById("titel").innerHTML = videoTitel;
                document.getElementById("beschrijving").innerHTML = besch;
                document.getElementById("likes").innerHTML = likes;
                document.getElementById("dislikes").innerHTML = dislikes;
                document.getElementById("upniffo").src = "img/upniffo-unclicked.png";
                document.getElementById("downniffo").src = "img/downniffo-unclicked.png";
                console.log(videoid);
                //            window.frames['frame'].location = url;
                //            document.write(" <iframe  id='frame' name='frame' src='" + url + "' width='600'  height='315'   allowfullscreen></iframe>");
                document.getElementById("frame").style.display = "block";
                //            let video scroll stop
                clickedVideo = true;
            }
            
            //sluit video popup
            function closePopup() {
                document.getElementById("popup").innnerHTML = '';
                document.getElementById("popup").src = "placeholder";
                document.getElementById("frame").style.display = "none";
                //start de scroll again
                clickedVideo = false;
                videoidtest = 0; 
                beoordelinggebruiker = undefined;
                clearInterval(sendtimestampajax);
            }

            //de auto slide show

            const container = document.getElementsByClassName("topVideoContainer")[0];
            var oldPosition = 0;
            function scrollTopVideos() {
                var start = setInterval(() => {
                    //als er niet op een video is geklikt
                    if (clickedVideo === false) {
                        //sla de postie aan vast wanneer er nog niet is gescrolled
                        oldPosition = container.scrollLeft;
                        //verplaats hem 1px
                        container.scrollLeft = container.scrollLeft + 1;
                    }
                    //als hij niet meer een px is verschoven
                    if (container.scrollLeft === oldPosition) {
                        console.log('stop');
                        //stopt hij met scrollen
                        clearInterval(start);
                        setTimeout(function () {
                            returnToStart();
                        }, 2500);
                    }
                    //hij doet dit elke 15 miliseconden tot hij is gestopt
                }, 15);
            }

            function returnToStart() {
                var eind = setInterval(() => {
                    if (container.scrollLeft !== 0 && clickedVideo === false) {
                        container.scroll(0, 0, 'smooth');
                    }
                    if (container.scrollLeft === 0) {
                        clearInterval(eind);
                        setTimeout(function () {
                            scrollTopVideos();
                        }, 2500);
                    }
                }, 1);
            }

            // function die wordt geactieveerd wanneer je in een div scrollt
            // naam en nummer geven aan welke div het is
            function scrollHorizantal(e, naam, nummer) {
                var item = document.getElementsByClassName(naam)[nummer];
                var oldLoc = 0;
                // zorg ervoor dat hij de body niet scrollt als je in een scrollbare div scrollt

                if (e.deltaY > 0) {
                    oldLoc = item.scrollLeft;
                    // als je naar beneden scrollt
                    item.scrollLeft += 25;
                    if (oldLoc !== item.scrollLeft) {
                        e.preventDefault();
                    }
                } else {
                    oldLoc = item.scrollLeft;
                    //en als je om hoog scrolt
                    item.scrollLeft -= 25;
                    if (oldLoc !== item.scrollLeft) {
                        e.preventDefault();
                    }
                }
            }
        </script>    
    <?php } ?>
