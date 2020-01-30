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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <title>Beheer</title>
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css"/>
        <link href="stylesheet/admin.css" rel="stylesheet" type="text/css">
    </head>
    <body>
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
                            $categorieTable = "categorie";
                            $cat = "";
                            $selectQeury = "SELECT playbackid, categorie.naam, titel, beschrijving, leeftijd, video_categorie.categorieid, video_categorie.vidcatid 
                                            FROM video 
                                            JOIN video_categorie ON video.videoid=video_categorie.videoid 
                                            JOIN categorie ON video_categorie.categorieid = categorie.categorieid 
                                            WHERE video.videoid =" . $videoId;
                            //$selectQeury = "SELECT playbackid, titel, beschrijving, UploadedBy, categorieid, leeftijd FROM $table WHERE videoid = $videoId";
                            if($stmt = mysqli_prepare($conn, $selectQeury)){
                                    mysqli_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $pId, $naam, $titel, $beschrijving, $leeftijdR, $cId, $vcId);
                                    mysqli_stmt_store_result($stmt);
                                    if(mysqli_stmt_num_rows($stmt) == 0){
                                        echo "deze videoid is niet bekend, kies een andere.";
                                    } else {
                                        while(mysqli_stmt_fetch($stmt)){
                                            $cat .= "$naam,";
                                        }
                                        if(mysqli_stmt_num_rows($stmt)>0){
                                        echo '<form action="" method="post">
                                        <h1>Video Aanpassen</h1>
                                        <div id="formsubmit">
                                            <div id="submitrowleft">
                                                <input type="text" name="videourl" value="'.$pId.'" class="textfield">
                                                <input type="text" name="titel" value="'.$titel.'" class="textfield">
                                                <input type="text" name="leeftijd" value="'.$leeftijdR.'" class="textfield">
                                            </div>
                                            <div id="submitrowright">
                                                <input type="text" name="categorie" value="'.$cat.'" class="textfield">
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
                                            if(empty($_POST["leeftijd"])){
                                                echo "Voer een leeftijd in.";
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
                                                $leeftijd = filter_input(INPUT_POST, 'leeftijd', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $categorie = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $beschrijving = filter_input(INPUT_POST, 'beschrijving', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $maker = $id;
                                                $explodeCategorie = explode(",", $categorie);
                                                // $countCategorie = count($explodeCategorie);
                                                // $test = "Horror";
                                                $categorieSelect = "SELECT * FROM categorie WHERE naam = ?";
                                                //selecteer de hoogste categorieid om deze te koppelen aan de videocategorie
                                               foreach($explodeCategorie as $checkCategorie){
                                                    // echo $categorieSelect . "<br>";
                                                    if($cSelectSTMT = mysqli_prepare($conn, $categorieSelect)){
                                                        mysqli_stmt_bind_param($cSelectSTMT, 's', $checkCategorie);
                                                        mysqli_execute($cSelectSTMT);
                                                        mysqli_stmt_bind_result($cSelectSTMT, $categorieid, $cSelectNaam);
                                                        echo $cSelectNaam . "<br>";
                                                        mysqli_stmt_store_result($cSelectSTMT);
                                                        mysqli_stmt_fetch($cSelectSTMT);
                                                        if(mysqli_stmt_num_rows($cSelectSTMT) > 0){
                                                            // echo "De categorie $cSelectNaam bestaat al.";
                                                        } else { 
                                                            $categorieInsert = "INSERT INTO $categorieTable VALUES(NULL, ?)";
                                                            if($cInsertSTMT = mysqli_prepare($conn,  $categorieInsert)){
                                                            //    for($a = 0; $a <2; $a++){
                                                                   if($checkCategorie != $cSelectNaam){
                                                                        // echo $insertCategorie . " " . $cSelectNaam . "<br>"; 
                                                //---------------------------------Filter om niet de bestaande categorieën toe toevoegen maken----------------------------------------------------//
                                                                        mysqli_stmt_bind_param($cInsertSTMT, 's', $checkCategorie);
                                                                        if(mysqli_stmt_execute($cInsertSTMT) === FALSE){
                                                                            echo "Het was niet mogelijk om de query uittevoeren". "<p>Error code "
                                                                            . mysqli_errno($conn)
                                                                            . ": "
                                                                            . mysqli_error($conn)
                                                                            . "</p>";
                                                                        } else {
                                                                            echo "De categorie is met succes gewijzigd.";
                                                                        } 
                                                                    }  
                                                                // }
                                                            }
                                                            // echo 'De categorie "' . $categorieTest . '" bestaat nog niet!';
                                                        }
                                                    }
                                                }
                                                $videoIdQeury = "SELECT MAX(videoid) as maxvideoid FROM video";
                                                if($maxvideoSTMT = mysqli_prepare($conn, $videoIdQeury)){
                                                    mysqli_execute($maxvideoSTMT);
                                                    mysqli_stmt_bind_result($maxvideoSTMT, $maxvideoid);
                                                    mysqli_stmt_store_result($maxvideoSTMT);
                                                    mysqli_stmt_fetch($maxvideoSTMT);
                                                    // echo "de laatste videoid = " . $maxvideoid . "<br>";
                                                }
                                                mysqli_stmt_close($maxvideoSTMT);
                                                $deleteCategorie = "DELETE FROM video_categorie WHERE videoid =" . $videoId;
                                                if (mysqli_query($conn, $deleteCategorie)) {
                                                    echo "Record deleted successfully";
                                                } else {
                                                    echo "Error deleting record: " . mysqli_error($conn);
                                                }
                                               
                                                foreach($explodeCategorie as $vidCatCategorie){
                                                    
                                                    $SelectcategorieId = "SELECT naam, categorieid FROM $categorieTable WHERE naam =?";
                                                    
                                                    if($categorieSTMT = mysqli_prepare($conn, $SelectcategorieId)){
                                                        mysqli_stmt_bind_param($categorieSTMT, 's',  $vidCatCategorie);
                                                        mysqli_execute($categorieSTMT);
                                                        mysqli_stmt_bind_result($categorieSTMT, $naam, $categorieid);
                                                        mysqli_stmt_store_result($categorieSTMT);
                                                        if(mysqli_stmt_fetch($categorieSTMT) > 0){
                                                            $videocatInsert = "INSERT INTO video_categorie VALUES(NULL, '$videoId', '$categorieid')";
                                                            if($VideoCatInsertstmt = mysqli_prepare($conn, $videocatInsert)){
                                                                // mysqli_stmt_bind_param($VideoInsertstmt, 'ssssii', $videoUrl, $titel, $beschrijving, $uploader , $leeftijd, $categorieid);
                                            
                                                                $videoCatInsertResult = mysqli_stmt_execute($VideoCatInsertstmt);
                                                                if($videoCatInsertResult === FALSE){
                                                                    echo "<p>De query kon niet uitgevoerd worden.</p>"
                                                                    . "<p>Error code "
                                                                    . mysqli_errno($conn)
                                                                    . ": "
                                                                    . mysqli_error($conn)
                                                                    . "</p>";
                                                                }
                                                            }
                                                            
                                                        } 
                                                    }
                                                    mysqli_stmt_close($categorieSTMT); 
                                                $updateQeury = "UPDATE video SET playbackid= '$videoUrl', titel= '$titel', beschrijving='$beschrijving', uploadedby= '$maker', leeftijd='$leeftijd' WHERE videoid=$videoId";
                                                if(mysqli_query($conn, $updateQeury)){
                                                    // echo "<p>video is met succes ge-update.</p><p><a href='videowijzigen.php'>Video wijzigen</a></p>";
                                                } else{
                                                    echo "Er ging iets verkeerd tijdens het updaten" . mysqli_error($conn);
                                                }
                                                
                                            }
                                        }
                                    }
                                    mysqli_stmt_close($stmt);
                                }
                                } else {
                                    echo "Er ging iets verkeerd met de query.";
                                }
                                 mysqli_close($conn);
                            
                        }else{
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
