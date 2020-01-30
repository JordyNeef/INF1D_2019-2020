<?php

function categorieVideos() {
    require 'conn.php';
    $catArray = array();
    $videoArray = array();
    if (!isset($_GET['naam'])) {
        $catStatement = "SELECT categorieid, naam
                            FROM categorie 
                            WHERE categorieid IN (SELECT categorieid 
                            FROM video_categorie)
                            ORDER BY rand()";
    } elseif (!isset($_GET['searchbar'])) {
        $getCategorie = htmlentities($_GET['naam']);
        $catStatement = "SELECT categorieid, naam
                            FROM categorie 
                            WHERE naam LIKE '%" . $getCategorie . "' AND categorieid IN (SELECT categorieid 
                            FROM video_categorie)";
    }
    if ($stmt = mysqli_prepare($conn, $catStatement)) {
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $categorie, $catNaam);
            mysqli_stmt_store_result($stmt);
            while (mysqli_stmt_fetch($stmt)) {
                array_push($catArray, $categorie, $catNaam);
            }
        }
        if (empty($catArray[0])) {
            echo'<div class = "CatagorieVideoLists">';
            echo"<div class ='videoCategorie'>";
            echo"<h2>Sorry but unfortunately there are no videos to display.</h2>";
            echo"</div>";
            echo"</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo'Failed to select categorie.';
    }
    $a = 0;
    $b = 0;
    $i = 0;
    $c = 0;
    $e = 0;
//    de limiet van het aantal videos
    $limit = 15;

    while ($a < 2 && !empty($catArray[$i])) {
        $d = 5;
        echo'<div class = "CatagorieVideoLists">';
        $b = $i + 1;
        if (!isset($_GET['searchbar'])) {
            echo'<h2>' . $catArray[$b] . '</h2>';
        } else {
            $limit = 30;
//            als searchbar in de url staat
            echo'<h2> Search results for: ' . $_GET['searchbar'] . '</h2>';
        }
        echo"<div onwheel='scrollHorizantal(event,\" videoCategorie \"," . $a . ")' class ='videoCategorie'>";
//        begin vooraan (wanneer hij voor de 2e keer in de loop gaat)
        reset($videoArray);
        while ($e < $limit && $e != $d) {
            if (isset($_GET['searchbar'])) {
//                zet a op 2 zodat hij niet nog eens de loop in gaat
                $a = 2;
                $searchValue = "%" . htmlentities($_GET['searchbar']) . "%";
//                de where wanneer er een seachvalue is
                $where = 'WHERE titel LIKE ? OR beschrijving LIKE ? OR categorie.naam LIKE ?';
            } else {
//                en de where wanneer die er niet is
                $where = "WHERE video_categorie.categorieid = ?";
            }
            $vidInCatStatement = "SELECT playbackid, titel, beschrijving, uploadedby, leeftijd, video_categorie.categorieid, video.videoid FROM video 
                                JOIN video_categorie ON video.videoid=video_categorie.videoid 
                                JOIN categorie ON video_categorie.categorieid = categorie.categorieid "
                    . $where . "
                                GROUP BY video.videoid";
            if ($stmt = mysqli_prepare($conn, $vidInCatStatement)) {
                if (isset($_GET['searchbar'])) {
                    mysqli_stmt_bind_param($stmt, "sss", $searchValue, $searchValue, $searchValue);
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $catArray[$i]);
                }
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_bind_result($stmt, $playbackid, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid);
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 0) {
                        echo"Sorry but unfortunately there are no videos to display.";
//                        stop loop zodat hij heel lege videos echoed
                        break;
                    }
                    while (mysqli_stmt_fetch($stmt)) {
                        explode('?=', $playbackid);
                        $d = mysqli_stmt_num_rows($stmt);
                        $playbackid1 = str_replace("https://www.youtube.com/watch?v=", "", $playbackid);
                        $url = "https://img.youtube.com/vi/" . $playbackid1 . "/0.jpg";
                        $informatieArray = array($url, $titel, $beschrijving, $uploadedby, $leeftijd, $categorieid, $videoid, $playbackid1);
                        array_push($videoArray, $informatieArray);
                    }
                }
                mysqli_stmt_close($stmt);
            } else {
//                        stop loop zodat hij heel lege videos echoed
                echo'failed to select videos';
                break;
            }
            // haalt de likes op uit de database 
            $sqllikes = "SELECT COUNT(ratingid) FROM rating WHERE videoid = ? && beoordeling = 1";
            if($stmt = mysqli_prepare($conn, $sqllikes)){
                mysqli_stmt_bind_param($stmt, "i", $videoArray[$c][6]); 
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
                mysqli_stmt_bind_param($stmt, "i", $videoArray[$c][6]);
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
            echo"<a class='video' onclick='popup(\"" . $videoArray[$c][7] . "\",\"" . htmlentities($videoArray[$c][1]) . "\",\"" . htmlentities($videoArray[$c][2]) . "\",\"" . $videoArray[$c][6] .  "\",\"" . $_SESSION["ID"] . "\",\"" . $likes . "\",\"" . $dislikes. "\",\"" . $_SESSION['admin'] . "\"); timestamp(\"" . $videoArray[$c][7] . "\",\"" . $videoArray[$c][6] . "\",\"" . $_SESSION["ID"] . "\"); likesystem(\"" . $videoArray[$c][6] . "\",\"" . $_SESSION["ID"] . "\",\"" . $likes . "\",\"" . $dislikes . "\")'";
            echo" style='background-image: url(\"" . $videoArray[$c][0] . "\")'>";
            //div in de a voor het displayen van info als je er over hovered
            echo"<div class='videoInfo'>"
            . "<h3 class='titel'>" . $videoArray[$c][1] . "</h3>"
            . "<h3 class='categorie'>Catagory/Catagories:<br>";
            $categorieStatement = "SELECT naam FROM `video_categorie` 
                JOIN categorie ON video_categorie.categorieid = categorie.categorieid
                WHERE videoid = " . $videoArray[$c][6];
            if ($stmt = mysqli_prepare($conn, $categorieStatement)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $categorieNaam);
                while (mysqli_stmt_fetch($stmt)) {
                    echo $categorieNaam . " ";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo"Prepare failed";
            }
            echo "</h3><h3 class='beschrijving'>Discription:<br>" . $videoArray[$c][2] . "</h3>"
            . "<h3 class='leeftijd'>Age:<br>" . $videoArray[$c][4] . "+</h3>"
            . "<h3 class='likes'>Rating: <br> Upniffo's: " . $likes . "<br> Downniffo's: " . $dislikes . "</h3></div></a>";
            $c++;
            $e++;
        }
//        leeg de array weer
        $videoArray = array();
        $c = 0;
        $i = $i + 2;
        $a++;
        $e = 0;
        echo'</div>';
        echo'</div>';
    }

    echo'</div>';
}

?>
