<?php
function frontvid()
{
    $vidcount = 1;
    $vidstatement=    "SELECT playbackid, titel, uploadedby, leeftijd, categorieid, videoid
						FROM video
                        WHERE videoid = $vidcount";
    mysqli_prepare($vidstatement);
    
    $videoid = 
    print "test";
    # code... w.i.p
    print '<iframe 
     src="https://www.youtube-nocookie.com/embed/'.$videoid.'"
         frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
        </iframe>';
        $vidcount() ++;
    
}
?>