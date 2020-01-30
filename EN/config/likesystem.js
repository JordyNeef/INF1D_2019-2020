var beoordelinggebruiker;
function likesystem (videoid, gebruikerid, totallikes, totaldislikes){
    // dit runt als je op de like knop drukt
    document.getElementById("like").onclick = function like() {
        console.log("like clicked");
        // hij gaat hierin als de video is gedisliked en je de video wilt liken
        if(disliked == 1){
            // update likes/dislikes
            likes++;
            dislikes--;
            document.getElementById("likes").innerHTML = likes;
            document.getElementById("dislikes").innerHTML = dislikes;
            liked = 1;
            disliked = 0;
            beoordeling = 1;
            console.log("beoordeling = " + beoordeling);
            // veranderd de knoppen naar geliked en niet gedisliked
            document.getElementById("downniffo").src = "img/downniffo-unclicked.png";
            document.getElementById("upniffo").src = "img/upniffo-clicked.png";
        }
        // hij gaat hierin als de video nog niet is geliked en je hem wil liken
        else if(liked == 0){
            // update likes/dislikes
            likes++;
            document.getElementById("likes").innerHTML = likes;
            liked = 1;
            beoordeling = 1;
            // veranderd de knoppen naar geliked
            console.log("beoordeling = " + beoordeling);
            document.getElementById("upniffo").src = "img/upniffo-clicked.png";
        }
        // hij gaat hierin als je de video hebt geliked en je hem wil unliken
        else{
            // update likes/dislikes
            likes--;
            document.getElementById("likes").innerHTML = likes;
            liked = 0;
            beoordeling = 1;
            console.log("likedtest");
            console.log("beoordeling = " + beoordeling);
            // veranderd de knoppen naar unliked
            document.getElementById("upniffo").src = "img/upniffo-unclicked.png";
        }
        // dit verstuurd de data naar sendlikesystem.php
        $.ajax({
                method: "POST",
                dataType: "json",
                url: "config/sendlikesystem.php",
                data: { videoid: videoid, gebruikerid: gebruikerid, beoordeling: beoordeling}
        })
    }
    
    // dit runt als je op de like knop drukt
    document.getElementById("dislike").onclick = function dislike() {
        console.log("test");
        // hij gaat hierin als je de video wilt disliken maar hij al geliked is 
        if(liked == 1){
            // update likes/dislikes
            likes--;
            dislikes++;
            document.getElementById("likes").innerHTML = likes;
            document.getElementById("dislikes").innerHTML = dislikes;
            disliked = 1;
            liked = 0;
            beoordeling = 0;
            // veranderd de knoppen naar gedisliked en niet geliked
            console.log("beoordeling = " + beoordeling);
            document.getElementById("upniffo").src = "img/upniffo-unclicked.png";
            document.getElementById("downniffo").src = "img/downniffo-clicked.png";
        }
        // hij gaat hierin als je de video wilt disliken en hij nog niet is gedisliked
        else if(disliked == 0){
            // update likes/dislikes
            dislikes++;
            document.getElementById("dislikes").innerHTML = dislikes;
            disliked = 1;
            beoordeling = 0;
            // veranderd de knoppen naar gedisliked
            console.log("beoordeling = " + beoordeling);
            document.getElementById("downniffo").src = "img/downniffo-clicked.png";
        }
        // hij gaat hierin als je de video wilt undisliken en hij al gedisliked is
        else{
             // update likes/dislikes
            dislikes--;
            document.getElementById("dislikes").innerHTML = dislikes;
            disliked = 0;
            beoordeling = 0;
            // veranderd de knoppen naar undisliked
            console.log("beoordeling = " + beoordeling);
            document.getElementById("downniffo").src = "img/downniffo-unclicked.png";
        }
        // dit verstuurd de data naar sendlikesystem.php
        $.ajax({
                method: "POST",
                dataType: "json",
                url: "config/sendlikesystem.php",
                data: { videoid: videoid, gebruikerid: gebruikerid, beoordeling: beoordeling}
        })
    }
    // dit haalt de beoordeling op van de gebruiker uit checklikegebruiker.php
    $.ajax({
        method: "POST",
        dataType: "json",
        async: false,
        url: "config/checklikegebruiker.php",
        data: { gebruikerid: gebruikerid, videoid: videoid},
        success: function(data, succes){
            console.log(data);
            beoordelinggebruiker = data["beoordelinggebruiker"];
            console.log("beoordeling " + beoordelinggebruiker);
        }
    });
    console.log("test " + gebruikerid + " " + videoid);
    var beoordeling;
    var likes = totallikes;
    console.log("likes = " + likes);
    var dislikes = totaldislikes;
    console.log(likes);
    var liked = 0;
    var disliked = 0;
    // zet de knoppen als geliked of gedisliked als de gebruiker dit als had toen hij de pagina lade
    if(beoordelinggebruiker == 1){
        liked = 1;
        document.getElementById("upniffo").src = "img/upniffo-clicked.png";
    }
    else if(beoordelinggebruiker == 0){
        disliked = 1;
        document.getElementById("downniffo").src = "img/downniffo-clicked.png";
    }
    console.log("beoordeling gebruiker:" + beoordelinggebruiker);
    console.log(liked);
    console.log(disliked);
}
