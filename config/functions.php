<?php
    session_start();
    //checkt of je ingelogd bent
    if(isset($_SESSION["login"])){
        //sessies definen
        $id = $_SESSION["ID"];
        $usernamesession = $_SESSION["username"];
        $admin = $_SESSION["admin"];
        $proefversie = $_SESSION["proefversie"];
        $profilepic = $_SESSION["profilepic"];
        $email = $_SESSION["email"];
    } 
    else{
        header("location:login.php");
    }
    
function headerBar() { ?>
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
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="Get">
            <input class="searchInput" type="text" name="searchbar" placeholder="Zoeken...">
            <button type="submit" class="searchButton">
               <!-- <img src="img\search-solid.svg" alt="Zoek Knop"> -->
               <i class="fas fa-search"></i>
            </button>
        </form> 
    <?php
    //select 10 random categorien uit de database en plaats deze in de navbar: veranderd elke keer dat je hem herlaad
    $categorieQeury = "SELECT naam FROM categorie ORDER BY RAND() LIMIT 10;";
        mysqli_execute($categorieStmt);
        mysqli_stmt_bind_result($categorieStmt, $categorieNaam);
        mysqli_stmt_store_result($categorieStmt);
        echo '<!--vul hier catergorieen in-->';
        while(mysqli_stmt_fetch($categorieStmt)){
            echo '
        <a class="navText" href="index.php?='.$categorieNaam .'">'.$categorieNaam.'</a>';
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
