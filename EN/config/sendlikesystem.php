<?php
$connect = mysqli_connect("localhost", "root", "", "niffoflix");
// haalt de data op uit de ajax call
$videoid = $_POST["videoid"];
$beoordeling = $_POST["beoordeling"];
$gebruikerid = $_POST["gebruikerid"];
// checkt of de gebruiker de video heeft geliked of gedisliked
$sql = "SELECT beoordeling FROM rating WHERE gebruikerid = ? AND videoid = ?";
if($stmt = mysqli_prepare($connect, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_bind_result($stmt, $beoordelingdb);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        // slaat op of de gebruiker de video heeft geliked of gedisliked
        echo $beoordelingdb;
    }
    else{
        echo mysqli_error($connect);
        mysqli_stmt_close($stmt);
    }
}
else{
    echo mysqli_error($connect);
}

//checkt of hij al was geliked of niet
$sql = "SELECT beoordeling FROM rating WHERE gebruikerid = ? && videoid = ?";
if($stmt = mysqli_prepare($connect, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_bind_result($stmt, $beoordelingdb);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_fetch($stmt);
        // checkt of de hij iets terug krijgt van de query 
        if(mysqli_stmt_num_rows($stmt) == 0){
            mysqli_stmt_close($stmt);
            //verstuurd de beoordeling naar de database
            $sql = "INSERT INTO rating VALUES(NULL, ?, ?, ?)";
            if($stmt = mysqli_prepare($connect, $sql)){
                mysqli_stmt_bind_param($stmt, "iii", $gebruikerid, $videoid, $beoordeling);
                if(!mysqli_stmt_execute($stmt)){
                    echo mysqli_error($connect);
                }
                else{
                    echo 'Upniffo/Downniffo inserted';
                }
            }
            else{
                echo mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        }
        else{
            mysqli_stmt_close($stmt);
            // checkt of de beoordeling input en de beoordeling uit de database overeen komen
            if($beoordeling == $beoordelingdb){
                //verwijderd de beoordeling uit de database
                $sql = "DELETE FROM rating WHERE gebruikerid = ? && videoid = ?";
                if($stmt = mysqli_prepare($connect, $sql)){
                    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
                    if(!mysqli_stmt_execute($stmt)){
                    echo mysqli_error($stmt); 
                    }
                    else{
                        echo "Upniffo/Downniffo deleted";
                    }
                }
                else{
                    echo mysqli_error($stmt);
                }
                mysqli_stmt_close($stmt);
            }
            else{
                //update de beoordeling als die wordt veranderd maar wel in de database staat
                $sql = "UPDATE rating SET beoordeling = ? WHERE gebruikerid = ? && videoid = ?";
                if($stmt = mysqli_prepare($connect, $sql)){
                    mysqli_stmt_bind_param($stmt, "iii", $beoordeling, $gebruikerid, $videoid);
                    if(!mysqli_stmt_execute($stmt)){
                        echo  mysqli_error($connect);    
                    }
                    else{
                        echo "Upniffo/Downniffo updated";
                    }
                }
                else{
                    echo mysqli_error($connect);
                }
            }
        }
    }
    else{
        echo mysqli_error($connect);
    }
}
else{
    echo mysqli_error($connect);
}
?>
