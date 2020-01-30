<?php

function frontvidthumb() {
    require 'conn.php';
    $vidstatement = "SELECT playbackid, titel, beschrijving, uploadedby, leeftijd, video_categorie.categorieid, video.videoid, COUNT(rating.videoid) as score 
    FROM video
    JOIN video_categorie ON video.videoid=video_categorie.videoid
    JOIN rating ON video.videoid = rating.videoid
    WHERE rating.beoordeling = 1
    GROUP BY video.videoid
    ORDER BY score DESC
    LIMIT 10 ";
    $videoArray = array();
    $i = 0;
    $a = 0;
    $novideos = FALSE;
    if ($stmt = mysqli_prepare($conn, $vidstatement)) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $playbackid, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid, $score);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 0) {
                echo"Sorry but unfortunately there are no videos to display.";
                $novideos = TRUE;
            }
            while (mysqli_stmt_fetch($stmt)) {
                explode('?=', $playbackid);
                $playbackid1 = str_replace("https://www.youtube.com/watch?v=", "", $playbackid);
                $url = "https://img.youtube.com/vi/" . $playbackid1 . "/0.jpg";
                $informatieArray = array($url, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid, $playbackid1);
                array_push($videoArray, $informatieArray);
                $i++;
            }
        }
        mysqli_stmt_close($stmt);
        $gebruikerid = $_SESSION["ID"];
        while ($a < $i && $novideos == FALSE) {
            //haalt de likes op van de video
            $sqllikes = "SELECT COUNT(ratingid) FROM rating WHERE videoid = ? && beoordeling = 1";
            if($stmt = mysqli_prepare($conn, $sqllikes)){
                mysqli_stmt_bind_param($stmt, "i", $videoArray[$a][6]); 
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_bind_result($stmt, $likes);
                    mysqli_stmt_fetch($stmt);
                }
                else{
                    echo mysqli_error($connect);
                }
            }
            else{
                echo mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
            
            //haalt de dislikes op van de videos
            $sqldislikes = "SELECT COUNT(ratingid) FROM rating WHERE videoid = ? && beoordeling = 0";
            if($stmt = mysqli_prepare($conn, $sqldislikes)){
                mysqli_stmt_bind_param($stmt, "i", $videoArray[$a][6]);
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_bind_result($stmt, $dislikes);
                    mysqli_stmt_fetch($stmt);
                }
                else{
                    echo mysqli_error($connect);
                }
            }
            else{
                echo mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
//             <a> tag die als achtergrond plaatje de thumbnail heeft
//            en een onklik event die de functie popup uitvoert (openen van videospeler)
//            functie ziet er uit als: popup(playbackid, titel, beschrijving); (geef je mee voor het displayen in de popup in het text vak)
            echo"<a class='video' onclick='popup(\"" . $videoArray[$a][7] . "\",\"" . htmlentities($videoArray[$a][1]) . "\",\"" . htmlentities($videoArray[$a][2]) . "\",\"" . $videoArray[$a][6] . "\",\"" . $_SESSION["ID"] . "\",\"" . $likes . "\",\"" . $dislikes . "\"); timestamp(\"" . $videoArray[$a][7] . "\",\"" . $videoArray[$a][6] . "\",\"" . $_SESSION["ID"] . "\"); likesystem(\"" . $videoArray[$a][6] . "\",\"" . $_SESSION["ID"] . "\",\"" . $likes . "\",\"" . $dislikes . "\")'";
            echo" style='background-image: url(\"" . $videoArray[$a][0] . "\")'>";
            //div in de a voor het displayen van info als je er over hovered
            echo"<div class='videoInfo'>"
            . "<h3 class='titel'>" . $videoArray[$a][1] . "</h3>"
            . "<h3 class='categorie'>Categorie(en):<br>";
//            scheid de categorieids van elkaar
            $categorieArray = explode(',', $videoArray[$a][5]);
//            echo alle categorieen waar een filmpje onder valt
            //foreach ($categorieArray as $categorie) {
//                maak van de string een int (want hij zag het als string)
            //$cat = intval($categorie);
            $categorieStatement = "SELECT naam FROM `video_categorie` 
                JOIN categorie ON video_categorie.categorieid = categorie.categorieid
                WHERE videoid = " . $videoArray[$a][6];
            if ($stmt = mysqli_prepare($conn, $categorieStatement)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $categorieNaam);
                while (mysqli_stmt_fetch($stmt)) {
                    echo $categorieNaam . " ";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo"prepare failed";
            }
            
            //}
            echo "</h3><h3 class='beschrijving'>Beschrijving:<br>" . $videoArray[$a][2] . "</h3>"
            . "<h3 class='leeftijd'>Leeftijd:<br>" . $videoArray[$a][4] . "+</h3>"
            . "<h3 class='likes'>Beoordeling:<br>Likes: " . $likes . "</br>Dislikes: " . $dislikes . "</h3></div></a>";
            $a++;
        }
    } else {
        echo mysqli_error($conn);
    }
}

?>
