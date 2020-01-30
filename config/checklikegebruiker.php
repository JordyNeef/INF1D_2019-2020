<?php
include("conn.php");
$gebruikerid = $_POST["gebruikerid"];
$videoid = $_POST["videoid"];
$sql = "SELECT beoordeling FROM rating WHERE videoid = ? AND gebruikerid = ?";
if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $videoid, $gebruikerid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $beoordelinggebruiker);
            mysqli_stmt_fetch($stmt);
            $array = ["beoordelinggebruiker" => $beoordelinggebruiker];
            echo json_encode($array);
        }
        else{
        }
    }
    else{
    echo mysqli_error($conn);
    }
}
else{
    echo mysqli_error($conn);
}
mysqli_stmt_close($stmt);
?>
