<!DOCTYPE html>
<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/conn.php'; 
        if(!isset($_SESSION['login']) && !isset($_SESSION['admin'])){
            header("login.php");
        }?>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <title>Beheer</title>
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css"/>
        <link href="stylesheet/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body onresize="checkOpenForResponsive();">
        <div id="containersubmit">
            <div id="containersubmitlogo">
                <?php
                    headerBar();
                    navBar();
                ?>
            </div>
            <div id="form">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <h1>Wijzig een video</h1>
                    <div id="wijzigvideo">
                            <input type="number" name="videoid" placeholder="videoid van een video..." class="textfield">
                            <div id="videowijzigenbuttons">
                                <input type="submit" name="verwijder" value="Video verwijderen" id="verwijderbutton">
                                <input type="submit" name="wijzig" value="wijzig video" id="wijzigbutton">
                            </div>
                    </div>
                    <div id="formresult">
                        <?php
                            if(isset($_POST['verwijder'])){
                                if(empty($_POST['videoid'])){
                                    echo "kies welke video moet worden verwijderd.";
                                } else {
                                    if($conn === FALSE){
                                        echo "Er kon niet worden verbonden met de database.";
                                    } else{
                                        $videoId = filter_input(INPUT_POST, 'videoid', FILTER_SANITIZE_SPECIAL_CHARS);
                                        $table = "video";
                                        $verwijderQeury = "DELETE video.*, video_categorie.* from video, video_categorie WHERE video.videoid=video_categorie.videoid AND video.videoid=".$videoId;
                                        if(mysqli_query($conn, $verwijderQeury)){
                                            echo "De video is met succes verwijderd.";
                                        } else{
                                            echo "Er ging iets fout met het verwijderen van de video" . mysqli_error($conn);
                                        }
                                        mysqli_close($conn);
                                    }  
                                }
                            }
                            if(isset($_POST['wijzig'])){
                                if(empty($_POST['videoid'])){
                                    echo "kies welke video moet worden verwijderd.";
                                } else {
                                    if($conn === FALSE){
                                        echo "Er kon niet worden verbonden met de database.";
                                    } else{
                                        $videoId = filter_input(INPUT_POST, 'videoid', FILTER_SANITIZE_SPECIAL_CHARS);
                                        header('Location: videoaanpassen.php?videoid= '.$videoId.'');
                                    }
                                    mysqli_close($conn);  
                                } 
                            }
                        ?>
                    </div>  
                </form>
            </div>
        </div>
    </body>
    <?php navScript();?>
</html>
