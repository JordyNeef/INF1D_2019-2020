<?php
$connect = mysqli_connect("localhost", "root", "", "niffoflix");
$videoid = $_POST["videoid"];
$beoordeling = $_POST["beoordeling"];
$gebruikerid = $_POST["gebruikerid"];

$sql = "SELECT beoordeling FROM rating WHERE gebruikerid = ? AND videoid = ?";
if($stmt = mysqli_prepare($connect, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_bind_result($stmt, $beoordelingdb);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
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
//insert into database
$sql = "SELECT beoordeling FROM rating WHERE gebruikerid = ? && videoid = ?";
if($stmt = mysqli_prepare($connect, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_bind_result($stmt, $beoordelingdb);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_fetch($stmt);
        if(mysqli_stmt_num_rows($stmt) == 0){
            mysqli_stmt_close($stmt);
            $connect = mysqli_connect("localhost", "root", "", "niffoflix");
            $sql = "INSERT INTO rating VALUES(NULL, ?, ?, ?)";
            if($stmt = mysqli_prepare($connect, $sql)){
                mysqli_stmt_bind_param($stmt, "iii", $gebruikerid, $videoid, $beoordeling);
                if(!mysqli_stmt_execute($stmt)){
                    echo mysqli_error($connect);
                }
                else{
                    echo 'like/dislike inserted';
                }
            }
            else{
                echo mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        }
        else{
            mysqli_stmt_close($stmt);
            if($beoordeling == $beoordelingdb){
                //verwijderd rating uit de database
                $sql = "DELETE FROM rating WHERE gebruikerid = ? && videoid = ?";
                if($stmt = mysqli_prepare($connect, $sql)){
                    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
                    if(!mysqli_stmt_execute($stmt)){
                    echo mysqli_error($stmt); 
                    }
                    else{
                        echo "like/dislike deleted";
                    }
                }
                else{
                    echo mysqli_error($stmt);
                }
                mysqli_stmt_close($stmt);
            }
            else{
                //update rating als die wordt veranderd maar wel in de database staat
                $sql = "UPDATE rating SET beoordeling = ? WHERE gebruikerid = ? && videoid = ?";
                if($stmt = mysqli_prepare($connect, $sql)){
                    mysqli_stmt_bind_param($stmt, "iii", $beoordeling, $gebruikerid, $videoid);
                    if(!mysqli_stmt_execute($stmt)){
                        echo  mysqli_error($connect);    
                    }
                    else{
                        echo "like/dislike updated";
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
