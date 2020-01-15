<?php
    function frontvid()
    {
        require 'conn.php'; 

        $vidstatement=    "SELECT playbackid, titel, uploadedby, leeftijd, categorieid, videoid
                            FROM video ";

        if($stmt = mysqli_prepare($conn ,$vidstatement)){
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt, $playbackid, $titel, $uploadedby, $leeftijd, $categorieid, $videoid);
                while(mysqli_stmt_fetch($stmt)){
                    explode( '?=', $playbackid);
                    $urlid = str_replace("https://www.youtube.com/watch?v=","",$playbackid."?autoplay=1");
                    echo 
                    '<iframe class="video" width="100%" height="100%"
                    src="https://www.youtube-nocookie.com/embed/'.$urlid.'"
                        frameborder="0"  allow="autoplay; encrypted-media" allowfullscreen>
                        </iframe>'
                    ;
                }
            }
            else {
                echo mysqli_error($conn);
            }
        } 
        else{
           echo mysqli_error($conn);
        }

    }
?>