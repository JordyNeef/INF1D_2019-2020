<?php

function frontvidthumb() {
    require 'conn.php';
<<<<<<< HEAD
    $vidstatement = "SELECT playbackid, titel, beschrijving, uploadedby, leeftijd, categorieid, videoid
                    FROM video";
=======

    $vidstatement = "SELECT playbackid, titel, beschrijving, uploadedby, leeftijd, video_categorie.categorieid, video.videoid
    FROM video
    JOIN video_categorie ON video.videoid=video_categorie.videoid
    GROUP BY video.videoid
    LIMIT 10 ";
>>>>>>> 08ea29e1f7afe25b00fb2c567fb00a9e35d24b35
    $videoArray = array();
    $i = 0;
    $a = 0;
    if ($stmt = mysqli_prepare($conn, $vidstatement)) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $playbackid, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid);
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
        while ($a < $i) {
//             <a> tag die als achtergrond plaatje de thumbnail heeft
//            en een onklik event die de functie popup uitvoert (openen van videospeler)
//            functie ziet er uit als: popup(playbackid, titel, beschrijving); (geef je mee voor het displayen in de popup in het text vak)
            echo"<a class='video' onclick='popup(\"" . $videoArray[$a][7] . "\",\"" . htmlentities($videoArray[$a][1]) . "\",\"" . htmlentities($videoArray[$a][2]) . "\",\"" . $videoArray[$a][6] .  "\",\"" . $_SESSION["ID"] . "\"); timestamp(\"" . $videoArray[$a][7] . "\",\"" . $videoArray[$a][6] . "\",\"" . $_SESSION["ID"] . "\")'";
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
                WHERE videoid = " . $videoid;
                if ($stmt = mysqli_prepare($conn, $categorieStatement)) {
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $categorieNaam);
                    while(mysqli_stmt_fetch($stmt)){
                        echo $categorieNaam . " ";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo"prepare failed";
                }
            //}
            echo "</h3><h3 class='beschrijving'>Beschrijving:<br>" . $videoArray[$a][2] . "</h3>"
            . "<h3 class='leeftijd'>Leeftijd:<br>" . $videoArray[$a][4] . "</h3>"
            . "<h3 class='likes'>Beoordeling:<br>moet nog toegevoegd worden</h3></div></a>";
            $a++;
        }
    } else {
        echo mysqli_error($conn);
    }
}

?>
