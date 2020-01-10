<!DOCTYPE html>
<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/conn.php'; ?>
        <?php 
            require "config/sessions.php";
            if($_SESSION["admin"] == false){
                header("location:index.php");
            }
        ?>
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <title>Beheer</title>
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css"/>
        <link type="text/css" rel="stylesheet" href="stylesheet/admin.css"/>
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
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <h1>Toevoegen van een video</h1>
                    <div id="formsubmit">
                        <div id="submitrowleft">
                            <input type="text" name="videourl" placeholder="videourl..." class="textfield">
                            <input type="text" name="titel" placeholder="titel van de video..." class="textfield">
                            <input type="text" name="catagorie" placeholder="catagorie...(gebruik commas inplaats van spaties a.u.b.)." class="textfield">
                        </div>
                        <div id="submitrowright">
                            <input type="number" name="leeftijd" placeholder="minimale leeftijd..." class="textfield">
                            <textarea name="beschrijving" placeholder="beschrijving..."></textarea>
                            <div id="formresult">
                                <?php
                                    if(isset($_POST['submit'])){
                                        if(empty($_POST['videourl']) || empty($_POST['titel']) || empty($_POST['catagorie']) || 
                                        empty($_POST['beschrijving'])){
                                            echo "<p>de volgende velden zijn nog leeg";
                                            if(empty($_POST['videourl'])){
                                                echo ", video url";
                                            }
                                            if(empty($_POST['titel'])){
                                                echo ", titel";
                                            }
                                            if(empty($_POST['catagorie'])){
                                                echo ", catagorie";
                                            }
                                            if(empty($_POST['beschrijving'])){
                                                echo ", beschrijving";
                                            }   
                                            echo ".</p>";
                                        } else{
                                            if($conn === FALSE){
                                                echo "Unable to connect to database.";
                                            } else{
                                                $videoUrl = filter_input(INPUT_POST, 'videourl', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $titel = filter_input(INPUT_POST, 'titel', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $uploader = $_SESSION["username"];
                                                $checkCategorie = filter_input(INPUT_POST, 'catagorie', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $beschrijving = filter_input(INPUT_POST, 'beschrijving', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $leeftijd = filter_input(INPUT_POST, 'leeftijd', FILTER_SANITIZE_SPECIAL_CHARS);
                                                $table = "video";
                                                $categorieen = NULL;
                                                $explodeCategorie = explode(",", $checkCategorie);
                                                $countCategorie = count($explodeCategorie);
                                                $videoTable = "video";
                                                $categorieTable = "categorie";
                                                $checkQuery = "SELECT * FROM categorie";
                                                if($checkStmt = mysqli_prepare($conn, $checkQuery)){
                                                    mysqli_execute($checkStmt);
                                                    mysqli_stmt_bind_result($checkStmt, $catId, $naam);
                                                    mysqli_stmt_store_result($checkStmt);
                                                    if(mysqli_stmt_num_rows($checkStmt) > 0){
                                                        // echo "<pre>";
                                                        // var_dump($checkStmt);
                                                        // echo "</pre>";
                                                        $a = 0;
                                                        while($a <$countCategorie){
                                                            mysqli_stmt_fetch($checkStmt);
                                                            $controleQeury = "SELECT naam FROM $categorieTable WHERE naam = '$explodeCategorie[$a]'";
                                                            if($checkStmt = mysqli_prepare($conn, $controleQeury)){
                                                                mysqli_execute($checkStmt);
                                                                mysqli_stmt_bind_result($checkStmt, $controleNaam);
                                                                mysqli_stmt_store_result($checkStmt);
                                                            }
                                                            mysqli_stmt_fetch($checkStmt);
                                                            if($controleNaam != $explodeCategorie[$a]){
                                                                $categorieinsertQeury = "INSERT INTO categorie VALUES (NULL, '$explodeCategorie[$a]')";
                                                                if(mysqli_query($conn, $categorieinsertQeury)){
                                                                    echo "$explodeCategorie[$a] toegevoegd.";
                                                                    
                                                                    $categorieen .= (mysqli_stmt_num_rows($checkStmt) + 1);
                                                                } else {
                                                                    echo "categorie kon niet worden toegevoegd.";
                                                                }
                                                                
                                                            } else {
                                                                $categorieen .=$catId . "| ";
                                                            }
                                                            // $insertQeury = "INSERT INTO categorie VALUES (NULL, '$explodeCategorie[$a]')";
                                                            // if(mysqli_query($conn, $insertQeury)){
                                                            //     echo "Categorie(en) toegevoegd.";
                                                            // } else {
                                                            //     echo "De categorie(en) kon(den) niet worden toegevoegd!";
                                                            // }
                                                            $a++;
                                                        
                                                        }
                                                    } else {
                                                        $a = 0;
                                                        while($a <$countCategorie){
                                                            $categorieInsertQeury = "INSERT INTO categorie VALUES (NULL, '$explodeCategorie[$a]')";
                                                            if(mysqli_query($conn, $categorieInsertQeury)){
                                                                echo "$explodeCategorie[$a] toegevoegd ";
                                                                $categorieen .=$catId . "| ";
                                                            } else {
                                                                echo "De categorie(en) kon(den) niet worden toegevoegd!";
                                                            }
                                                            $a++;
                                                        }
                                                        
                                                    }
                                                }   
                                            } 
                                            $insertQeury = "INSERT INTO " . $table . " VALUES(?, ?, ?, ?, ?, NULL, ?)";
                                            if($stmt = mysqli_prepare($conn, $insertQeury)){
                                                
                                                mysqli_stmt_bind_param($stmt, 'ssssii', $videoUrl, $titel, $beschrijving, $uploader , $leeftijd, $categorieen);
                                                echo $categorieen;
                                                $insertResult = mysqli_stmt_execute($stmt);
                                                
                                                if($insertResult === FALSE){
                                                    echo "<p>Unable to execute the query.</p>"
                                                    . "<p>Error code "
                                                    . mysqli_errno($conn)
                                                    . ": "
                                                    . mysqli_error($conn)
                                                    . "</p>";
                                                } else{
                                                    
                                                    echo "<br>Video succesfully uploaded";
                                                }
                                                mysqli_stmt_close($stmt);
                                            } else {
                                                echo "Qeury couldnt be executed<br>" . mysqli_error($conn);
                                            }
                                            mysqli_close($conn);
                                        } 
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
