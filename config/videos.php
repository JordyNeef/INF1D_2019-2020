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
                    str_replace("https://www.youtube.com/watch?v=","","$playbackid");
                    echo "<div class='video'>"
                    . '<iframe width="fill" height="fill" 
                    src="https://www.youtube-nocookie.com/embed/'.$playbackid.'"
                        frameborder="0"  allow="autoplay; encrypted-media" allowfullscreen>
                        </iframe>'
                    . "</div>";
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