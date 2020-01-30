<!DOCTYPE html>
<?php require 'config/functions.php'; ?>
<?php require 'config/conn.php'; 
if(!$_SESSION['admin'] == 1){
    header("location:index.php");
}
?>
<html>
    <head>
        <title>Admin Portal</title>
        <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'/>
        <link type="text/css" rel="stylesheet" href="stylesheet/admin.css" />
        <link type="text/css" rel="stylesheet" href="stylesheet/main.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <h1>Admin toewijzen</h1>
                    <div id="wijzigvideo">
                        <input type="text" name="gebruikersnaam" placeholder="gebruikersnaam" class="textfield">
                        <div id="videowijzigenbuttons">
                            <input type="submit" name="toewijzen" value="Admin toevoegen!" id="toewijzbutton">
                        </div>
                        <div id="toewijzresult">
                    <?php
                        if(isset($_POST['toewijzen'])){
                            if(empty($_POST['gebruikersnaam'])){
                                echo "Kies welke gebruiker u admin wilt maken.";
                            } else{
                                $gebruikerTable = "gebruiker";
                                $gebruikersnaam = filter_input(INPUT_POST, 'gebruikersnaam', FILTER_SANITIZE_SPECIAL_CHARS);
                                $adminQuery = "UPDATE $gebruikerTable SET admin=1 WHERE gebruikersnaam='$gebruikersnaam'";
                                if(mysqli_query($conn, $adminQuery)){
                                    echo "De gebruiker is nu een admin.";
                                } else {
                                    echo "er ging iets fout: De gebruiker kon geen admin worden gemaakt.";
                                }
                            }
                        }
                    ?>
                </div>
                    </div>
                </form>
                
            </div>
        </div>
    </body>
    <?php navScript();?>
</html>
