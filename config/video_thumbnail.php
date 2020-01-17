<?php

function frontvidthumb() {
    require 'conn.php';

    $vidstatement = "SELECT playbackid, titel, beschrijving, uploadedby, leeftijd, categorieid, videoid
                            FROM video ";
    $videoArray = array();
    $i = 0;
    $a = 0;
    if ($stmt = mysqli_prepare($conn, $vidstatement)) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $playbackid, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid);
            while (mysqli_stmt_fetch($stmt)) {
                $url = "https://img.youtube.com/vi/" . $playbackid . "/0.jpg";
                $informatieArray = array($url, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid);
                array_push($videoArray, $informatieArray);
                $i++;
            }
        }
        mysqli_stmt_close($stmt);
        while ($a < $i) {
            echo"<a class='video' href='index.php?videoId=";
            echo $videoArray[$a][6];
            echo"' style='background-image: url(\"" . $videoArray[$a][0] . "\")'><div class='videoInfo'>"
            . "<h3 class='titel'>" . $videoArray[$a][1] . "</h3>"
            . "<h3 class='categorie'>Categorie(en):<br>";
            $categorieArray = explode(',', $videoArray[$a][5]);
            foreach ($categorieArray as $categorie) {
                $cat = intval($categorie);
                $categorieStatement = "SELECT naam FROM `categorie` WHERE categorieid = " . $cat;
                if ($stmt1 = mysqli_prepare($conn, $categorieStatement)) {
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $categorieNaam);
                    mysqli_stmt_fetch($stmt1);
                    echo $categorieNaam . " ";
                    mysqli_stmt_close($stmt1);
                } else {
                    echo"prepare failed";
                }
            }
            echo "</h3><h3 class='beschrijving'>Beschrijving:<br>" . $videoArray[$a][2] . "</h3>"
            . "<h3 class='leeftijd'>Leeftijd:<br>" . $videoArray[$a][4] . "</h3>"
            . "<h3 class='likes'>Beoordeling:<br>sdfghj</h3></div></a>";
            echo "";
            $a++;
        }
    } else {
        echo mysqli_error($conn);
    }
}

?>