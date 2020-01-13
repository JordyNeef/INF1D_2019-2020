<?php
    function frontvid() {
        $videosarray = "SELECT videoid, titel, beschrijving FROM video";
        // shuffle($videosarray)
        echo "$videosarray";
    }
?>