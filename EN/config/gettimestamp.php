<?php
include("conn.php");
$gebruikerid = $_POST["gebruikerid"];
$videoid = $_POST["videoid"];

$sql = "SELECT tijdstip FROM kijksessie WHERE gebruikerid = ? AND videoid = ?";
if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $tijdpunt);
        mysqli_stmt_fetch($stmt);
        echo mysqli_error($conn);
        $array = ["timestamp" => $tijdpunt];
        echo json_encode($array);
    }
    else{
        echo "not executed";
        echo mysqli_error($conn);
    }
}
else{
    echo "not prepared";
    echo mysqli_error($conn);
}
?>
