<?php
include("conn.php");
// haalt de data op uit de ajax call
$gebruikerid = $_POST["gebruikerid"];
$videoid = $_POST["videoid"];

// haalt de timestamp op uit de database
$sql = "SELECT tijdstip FROM kijksessie WHERE gebruikerid = ? AND videoid = ?";
if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $tijdpunt);
        mysqli_stmt_fetch($stmt);
        echo mysqli_error($conn);
        // verstuurd de response terug naar de ajax call
        $array = ["timestamp" => $tijdpunt];
        echo json_encode($array);
    }
    else{
        echo "Niet uitgevoerd";
        echo mysqli_error($conn);
    }
}
else{
    echo "Niet voorbereid";
    echo mysqli_error($conn);
}
?>
