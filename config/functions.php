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
                <?php $profile_avatar = "img/avatar/" . $_SESSION["profilepic"]; ?>
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
                        echo"<a href='videotoevoegen.php'>video toevoegen</a>";
                        echo"<a href='videowijzigen.php'>video wijzigen</a>";
                        echo"<a href='admintoewijzen.php'>admin toewijzen</a>";
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
        <!-- <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="Get"> -->
        <input class="searchInput" type="text" name="searchbar" placeholder="Zoeken...">

        <!-- </form>  -->
        <?php
        //select 10 random categorien uit de database en plaats deze in de navbar: veranderd elke keer dat je hem herlaad
        $categorieQeury = "SELECT naam FROM categorie ORDER BY RAND() LIMIT 10;";
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
                //als de navbar open is
                if (open === true) {
                    //ga naar de functie die de breede bepaalt
                    navOpen();
                }
            }

            //open de navbar
            function navOpen() {
                checkWidth();
                //als de grote groter is dan 415px is de navbar 250px groot
                if (w > 415) {
                    document.getElementById("navBar").style.width = "250px";
                    document.getElementById("transparentFakeContainer").style.width = "calc(100% - 250px)";
                    for (i = 0; i < navText.length; i++) {
                        //text in de navbar moet de zelfde breede want anders gaat hij bij het sluiten de text naast de navbar zetten (en is dus nog zichtbaar op het scherm)
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
                //maak alle breedes 0 en maak hem display hidden
                document.getElementById("navBar").style.width = "0px";
                document.getElementById("navBar").style.display = "hidden";
                document.getElementById("transparentFakeContainer").style.width = "0px";
                open = false;
            }

    //
    //        video afspeler
    //

    //            open video frame (popup) (wanneer je op thumbnail klikt)

            //kan nog meer displayen onder video door , wat je wilt tussen de haakjes te zetten en op die plek in video_thumbnail de variable in te vullen
            function popup(playback, videoTitel, besch) {
                //maak de scr van de iframe door de playbackid in te vullen (kan de tijd nog ingevult door &t='aantal minuten'm'aantal seconden's (t=0m00s voor 0:00) achter autoplay in te vullen )
                url = "https://www.youtube-nocookie.com/embed/" + playback + "?autoplay=1";
                //zet de src van de iframe op die je meekrijgt van de placeholder
                document.getElementById("popup").src = url;
                //geeft de titel aan de h4 met als id titel heeft (onder de iframe)
                document.getElementById("titel").innerHTML = videoTitel;
                //geeft de beschrijving aan de p met als id beschrijving heeft (onder de de titel van het filmpje)
                document.getElementById("beschrijving").innerHTML = besch;
    //            window.frames['frame'].location = url;
    //            document.write(" <iframe  id='frame' name='frame' src='" + url + "' width='600'  height='315'   allowfullscreen></iframe>");
                document.getElementById("frame").style.display = "block";
            }

    //            sluit video frame (wanneer je op kruisje klikt)

            function closePopup() {
                //
                //kan hier timestamp ophalen
                //

                //zet src op niks zodat hij stopt met spelen
                document.getElementById("popup").src = '';
                //zet display terug op none
                document.getElementById("frame").style.display = "none";
            }
        </script>    
    <?php } ?>
