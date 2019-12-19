<!DOCTYPE html>
<html>
    <head>
        <?php require 'config/functions.php'; ?>
        <?php require 'config/conn.php'; ?>
        <?php require "config/sessions.php";
        if($_SESSION["admin"] == false){
            header("location:index.php");
        }?>
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
                            <input type="text" name="maker" placeholder="Naam van de maker..." class="textfield">
                            <div id="formresult">
                <?php
                    if(isset($_POST['submit'])){
                        if(empty($_POST['videourl']) || empty($_POST['titel']) || empty($_POST['maker']) || empty($_POST['catagorie']) || 
                        empty($_POST['beschrijving'])){
                            echo "<p>de volgende velden zijn nog leeg";
                            if(empty($_POST['videourl'])){
                                echo ", video url";
                            }
                            if(empty($_POST['titel'])){
                                echo ", titel";
                            }
                            if(empty($_POST['maker'])){
                                echo ", maker";
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
                                $maker = $_SESSION["username"];
                                $catagorie = filter_input(INPUT_POST, 'catagorie', FILTER_SANITIZE_SPECIAL_CHARS);
                                $beschrijving = filter_input(INPUT_POST, 'beschrijving', FILTER_SANITIZE_SPECIAL_CHARS);
                                $leeftijd = filter_input(INPUT_POST, 'leeftijd', FILTER_SANITIZE_SPECIAL_CHARS);;
                                $table = "video";
                                $insertQeury = "INSERT INTO " . $table . " VALUES(NULL, ?, ?, ?, ?, ?, ?)";
                                if($stmt = mysqli_prepare($conn, $insertQeury)){
                                    mysqli_stmt_bind_param($stmt, 'sssssi', $videoUrl, $titel, $beschrijving, $maker, $catagorie, $leeftijd);
                                    $insertResult = mysqli_stmt_execute($stmt);
                                    mysqli_stmt_close($stmt);
                                    if($insertResult === FALSE){
                                        echo "<p>Unable to execute the query.</p>"
                                        . "<p>Error code "
                                        . mysqli_errno($conn)
                                        . ": "
                                        . mysqli_error($conn)
                                        . "</p>";
                                    } else{
                                        echo "Video succesfully uploaded";
                                    }
                                } else {
                                    echo "Qeury couldnt be executed<br>" . mysqli_error($conn);
                                }
                                mysqli_close($conn);
                            } 
                        }
                    }
                ?>
            </div>
                            
                        </div>
                        <div id="submitrowright">
                            <input type="number" name="catagorie" placeholder="catagorie..." class="textfield">
                            <input type="number" name="leeftijd" placeholder="minimale leeftijd..." class="textfield">
                            <textarea name="beschrijving" placeholder="beschrijving..."></textarea>
                            
                            <input type="submit" name="submit" value="Voeg video toe..." id="submitbutton">
                        </div>
                    </div>
               
                </form>
            </div>
           
        </div>
    </body>
    <?php navScript();?>
</html>
