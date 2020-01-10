<?php

function headerBar() { ?>
    <div class='header'>
        <div class="navOpenButton" onclick="navOpen();">
            <div class="navStreep"></div>
            <div class="navStreep"></div>
            <div class="navStreep"></div>
        </div>
        <div class="titleAndAccountButton">
            <div class="accountButton">
                <img src="img/account.png" alt="account icoontje">
                <div class="dropdown-content">
                    <a href="accountsettings.php">Account</a>
                    <a href="accountsettings.php">Settings</a>
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
    ?>
    <div id="navBar">
        <div class="navCloseButton"  onclick="navClose();">&#10005;</div>
        <input class="searchInput" type="text" name="searchbar" placeholder="Zoeken...">
        <a class="navText" href="#">bla bla bla</a>
        <a class="navText" href="#">just some text</a>
        <a class="navText" href="#">bla bla bla</a>
    </div>
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
    </script>
<?php } ?>
