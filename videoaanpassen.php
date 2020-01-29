<!DOCTYPE html>
<html>
    <head>
        <?php require 'config/functions.php';?>
        <?php require 'config/conn.php';?>
        <?php 
            if(!isset($_SESSION["login"]) && !isset($_SESSION['admin'])){
                header("login.php");
            }
        ?>
        <meta charset="UTF-8">
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
                
                    <?php
                    if($conn === FALSE){
                        echo "Er kon niet worden verbonden met de database.";
                    } else{
                        $videoId = filter_input(INPUT_GET, 'videoid', FILTER_SANITIZE_SPECIAL_CHARS);
                        if(isset($videoId)){
                            $table = "video";
                            $selectQeury = "SELECT playbackid, titel, beschrijving, UploadedBy, categorieid, leeftijd FROM $table WHERE videoid = $videoId";
                            if($stmt = mysqli_prepare($conn, $selectQeury)){
                                    mysqli_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $pId, $titel, $beschrijving, $uploadBy, $vcId, $leeftijdR);
                                    mysqli_stmt_store_result($stmt);
                                    if(mysqli_stmt_num_rows($stmt) == 0){
                                        echo "deze videoid is niet bekend, kies een andere.";
                                    } else {
                                        while(mysqli_stmt_fetch($stmt)){
                                        echo '<form action="" method="post">
                                        <h1>Video Aanpassen</h1>
                                        <div id="formsubmit">
                                            <div id="submitrowleft">
                                                <input type="text" name="videourl" value="'.$pId.'" class="textfield">
                                                <input type="text" name="titel" value="'.$titel.'" class="textfield">
                                                <input type="text" name="maker" value="'.$uploadBy.'" class="textfield">
                                            </div>
                                            <div id="submitrowright">
                                                <input type="text" name="categorie" value="'.$vcId.'" class="textfield">
                                                <textarea name="beschrijving">'.$beschrijving.'</textarea>
                                                <input type="submit" name="wijzig" value="Voeg video toe..." id="submitbutton">
                                            </div>';
                                        }
                                        echo "</table>";
                                        if(isset($_POST['wijzig'])){
                                            if(empty($_POST["videourl"])){
                                                echo "Voer een videourl in.";
                                            }
                                            if(empty($_POST["titel"])){
                                                echo "Voer een titel in.";
                                            }
                                            if(empty($_POST["maker"])){
                                                echo "Voer een maker in.";
                                            }
                                            if(empty($_POST["categorie"])){
                                                echo "Voer een categorie in.";
                                            }
                                            if(empty($_POST["beschrijving"])){
                                                echo "Voer een beschrijving in.";
                                            } else{
                                                $videoUrl = filter_input(INPUT_POST, 'videourl', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $videoUrl = str_replace("https://www.youtube.com/watch?v=","",$videoUrl);
                                                $titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $maker = filter_input(INPUT_POST, 'maker', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $beschrijving = filter_input(INPUT_POST, 'beschrijving', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $updateQeury = "UPDATE video SET playbackid= '$videoUrl', titel= '$titel', beschrijving='$beschrijving', uploadedby= '$maker', categorieid='$categorie' WHERE videoid=$videoId";
                                                if(mysqli_query($conn, $updateQeury)){
                                                    echo "<p>video is met succes ge-update.</p><p><a href='videowijzigen.php'>Video wijzigen</a></p>";
                                                } else{
                                                    echo "er ging iets fout tijdens het updaten" . mysqli_error($conn);
                                                }
                                                
                                            }
                                        }
                                    }
                                    mysqli_stmt_close($stmt);
                                } else {
                                    echo "Something went wrong with the qeury.";
                                }
                                mysqli_close($conn);  
                        }
                        else{
                            header("location:videowijzigen.php");
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
