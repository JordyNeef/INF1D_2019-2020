<!DOCTYPE html>
<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/conn.php'; 
            if(!$_SESSION["admin"] == 1){
                header("location:index.php");
            }
            ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <title>Beheer</title>
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css"/>
        <link type="text/css" rel="stylesheet" href="stylesheet/admin.css"/>
    </head>
    <body onresize="checkOpenForResponsive()">
        <div id="containersubmit">
            <div id="containersubmitlogo">
                <?php
                    headerBar();
                    navBar();
                ?>
            </div>
            <div id="form">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <h1>Toevoegen van een video</h1>
                    <div id="formsubmit">
                        <div id="submitrowleft">
                            <input type="text" name="videourl" placeholder="videourl..." class="textfield">
                            <input type="text" name="titel" placeholder="titel van de video..." class="textfield">
                            <input type="text" name="categorie" placeholder="categorie...(gebruik commas inplaats van spaties a.u.b.)." class="textfield">
                        </div>
                        <div id="submitrowright">
                            <input type="number" name="leeftijd" placeholder="minimale leeftijd..." class="textfield">
                            <textarea name="beschrijving" placeholder="beschrijving..."></textarea>
                            <div id="formresult">
                                <?php
                                    if(isset($_POST['submit'])){
                                        if(empty($_POST['videourl']) || empty($_POST['titel']) || empty($_POST['categorie']) || 
                                        empty($_POST['beschrijving']) || empty($_POST['leeftijd'])){
                                            echo "<p>De volgende velden zijn nog leeg";
                                            if(empty($_POST['videourl'])){
                                                echo ", Video-url";
                                            }
                                            if(empty($_POST['titel'])){
                                                echo ", Titel";
                                            }
                                            if(empty($_POST['categorie'])){
                                                echo ", Categorie";
                                            }
                                            if(empty($_POST['beschrijving'])){
                                                echo ", Beschrijving";
                                            }   
                                            echo ".</p>";
                                            exit;
                                        } else{
                                            if($conn === FALSE){
                                                echo "Er kon geen verbinding worden gemaakt met de database. Probeer het later opnieuw.";
                                            } else{
                                                
                                                $videoUrl = filter_input(INPUT_POST, 'videourl', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $videoUrl = str_replace("https://www.youtube.com/watch?v=","",$videoUrl);
                                                $titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $uploader = $id;
                                                $categorieInput = filter_input(INPUT_POST, 'categorie', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $beschrijving = filter_input(INPUT_POST, 'beschrijving', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $leeftijd = filter_input(INPUT_POST, 'leeftijd', FILTER_SANITIZE_SPECIAL_CHARS);
                                                //de categorieén worden doormiddel van een comma ingevuld waardoor er meerdere in in input kunnen worden geplaatst
                                                $explodeCategorie = explode(",", $categorieInput); 
                                                // $countCategorie = count($explodeCategorie);
                                                // $videoTable = "video";
                                                $categorieTable = "categorie";
                                                // $checkQuery = "SELECT max(categorieid) as topid, categorieid, naam FROM categorie";
                                                $categorieTable = "categorie";
                                                $categorieSelect = "SELECT * FROM categorie WHERE naam = ?";
                                                //loopt door alle categorieën om zo meerdere te kunnen koppelen
                                                foreach($explodeCategorie as $checkCategorie){
                                                // echo $categorieSelect . "<br>";
                                                //selecteert de gegevens van de categorie zodat deze kan worden gecontroleerd en als deze nog niet aanwezig is aangemaakt
                                                    if($cSelectSTMT = mysqli_prepare($conn, $categorieSelect)){
                                                        mysqli_stmt_bind_param($cSelectSTMT, 's', $checkCategorie);
                                                        mysqli_execute($cSelectSTMT);
                                                        mysqli_stmt_bind_result($cSelectSTMT, $categorieid, $cSelectNaam);
                                                        mysqli_stmt_store_result($cSelectSTMT);
                                                        mysqli_stmt_fetch($cSelectSTMT);
                                                        if(mysqli_stmt_num_rows($cSelectSTMT) > 0){
                                                            //echo "De categorie $cSelectNaam bestaat al.";
                                                        } else {
                                                            $categorieInsert = "INSERT INTO $categorieTable VALUES(NULL, ?)";
                                                            if($cInsertSTMT = mysqli_prepare($conn,  $categorieInsert)){
                                                            //    for($a = 0; $a <2; $a++){
                                                                if($checkCategorie != $cSelectNaam){
                                                                    //als de categorie nog niet bekend is wordt deze toegevoegd
                                                                    // echo $insertCategorie . " " . $cSelectNaam . "<br>";    
                                                                    mysqli_stmt_bind_param($cInsertSTMT, 's', $checkCategorie);
                                                                    if(mysqli_stmt_execute($cInsertSTMT) === FALSE){
                                                                        echo "Het was niet mogelijk om de query uit te voeren". "<p>Error code "
                                                                        . mysqli_errno($conn)
                                                                        . ": "
                                                                        . mysqli_error($conn)
                                                                        . "</p>";
                                                                    }
                                                                }  
                                                                // }
                                                            }
                                                            // echo 'De categorie "' . $categorieTest . '" bestaat nog niet!';
                                                        }
                                                    }
                                                }
                                            mysqli_stmt_close($cSelectSTMT);  
                                            // de video wordt nu toegevoegd
                                            $videoInsertQeury = "INSERT INTO video VALUES(?, ?, ?, ?, ?, NULL)";
                                            if($VideoInsertstmt = mysqli_prepare($conn, $videoInsertQeury)){
                                                mysqli_stmt_bind_param($VideoInsertstmt, 'ssssi', $videoUrl, $titel, $beschrijving, $uploader , $leeftijd);
                                                $insertResult = mysqli_stmt_execute($VideoInsertstmt);
                                                if($insertResult === FALSE){
                                                    echo "<p>Het was niet mogelijk om de qeury uit te voeren.</p>"
                                                    . "<p>Error code "
                                                    . mysqli_errno($conn)
                                                    . ": "
                                                    . mysqli_error($conn)
                                                    . "</p>";
                                                } else{
                                                    echo "<br>Video succesvol geüpload";
                                                }
                                                //selecteerd de hoogste videoid om deze te koppelen aan een categorie
                                                $videoIdQeury = "SELECT MAX(videoid) as maxvideoid FROM video";
                                                if($maxvideoSTMT = mysqli_prepare($conn, $videoIdQeury)){
                                                    mysqli_execute($maxvideoSTMT);
                                                    mysqli_stmt_bind_result($maxvideoSTMT, $maxvideoid);
                                                    mysqli_stmt_store_result($maxvideoSTMT);
                                                    mysqli_stmt_fetch($maxvideoSTMT);
                                                }
                                                mysqli_stmt_close($maxvideoSTMT);
                                                foreach($explodeCategorie as $vidCatCategorie){
                                                    $SelectcategorieId = "SELECT naam, categorieid FROM $categorieTable WHERE naam =?";
                                                    
                                                    if($categorieSTMT = mysqli_prepare($conn, $SelectcategorieId)){
                                                        mysqli_stmt_bind_param($categorieSTMT, 's',  $vidCatCategorie);
                                                        mysqli_execute($categorieSTMT);
                                                        mysqli_stmt_bind_result($categorieSTMT, $naam, $categorieid);
                                                        mysqli_stmt_store_result($categorieSTMT);
                                                        if(mysqli_stmt_fetch($categorieSTMT) > 0){
                                                            $videocatInsert = "INSERT INTO video_categorie VALUES(NULL, '$maxvideoid', '$categorieid')";
                                                            if($VideoCatInsertstmt = mysqli_prepare($conn, $videocatInsert)){
                                                                // mysqli_stmt_bind_param($VideoInsertstmt, 'ssssii', $videoUrl, $titel, $beschrijving, $uploader , $leeftijd, $categorieid);
                                            
                                                                $videoCatInsertResult = mysqli_stmt_execute($VideoCatInsertstmt);
                                                                if($videoCatInsertResult === FALSE){
                                                                    echo "<p>Het was niet mogelijk om te query uit te voeren.</p>"
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
                                                } 
                                                    } else {
                                                        echo "De video kon niet worden toegevoegd.<br>";
                                                    }
                                                }
                                            }
                                            mysqli_stmt_close($VideoInsertstmt); 
                                            }
                                ?>
                            </div>
                            <input type="submit" name="submit" value="Voeg video toe..." id="submitbutton">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <?php navScript();?>
</html>
