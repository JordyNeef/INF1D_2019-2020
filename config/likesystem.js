var beoordelinggebruiker;
function likesystem (videoid, gebruikerid, totallikes, totaldislikes){
    document.getElementById("like").onclick = function like() {
        console.log("like clicked");
        if(disliked == 1){
            likes++;
            dislikes--;
            document.getElementById("likes").innerHTML = likes;
            document.getElementById("dislikes").innerHTML = "Dislikes " + dislikes;
            liked = 1;
            disliked = 0;
            beoordeling = 1;
            console.log("beoordeling = " + beoordeling);
            document.getElementById("downniffo").src = "img/downniffo-unclicked.png";
            document.getElementById("upniffo").src = "img/upniffo-clicked.png";
        }
        else if(liked == 0){
            likes++;
            document.getElementById("likes").innerHTML = likes;
            liked = 1;
            beoordeling = 1;
            console.log("beoordeling = " + beoordeling);
            document.getElementById("upniffo").src = "img/upniffo-clicked.png";
        }
        else{
            likes--;
            document.getElementById("likes").innerHTML = "Likes " + likes;
            liked = 0;
            beoordeling = 1;
            console.log("likedtest");
            console.log("beoordeling = " + beoordeling);
            document.getElementById("upniffo").src = "img/upniffo-unclicked.png";
        }
        $.ajax({
                method: "POST",
                dataType: "json",
                url: "config/sendlikesystem.php",
                data: { videoid: videoid, gebruikerid: gebruikerid, beoordeling: beoordeling}
        })
    }
        
    document.getElementById("dislike").onclick = function dislike() {
        console.log("test");
        if(liked == 1){
            likes--;
            dislikes++;
            document.getElementById("likes").innerHTML = "Likes " + likes;
            document.getElementById("dislikes").innerHTML = "Dislikes " + dislikes;
            disliked = 1;
            liked = 0;
            beoordeling = 0;
            console.log("beoordeling = " + beoordeling);
            document.getElementById("upniffo").src = "img/upniffo-unclicked.png";
            document.getElementById("downniffo").src = "img/downniffo-clicked.png";
        }
        else if(disliked == 0){
            dislikes++;
            document.getElementById("dislikes").innerHTML = "Dislikes " + dislikes;
            disliked = 1;
            beoordeling = 0;
            console.log("beoordeling = " + beoordeling);
            document.getElementById("downniffo").src = "img/downniffo-clicked.png";
        }
        else{
            dislikes--;
            document.getElementById("dislikes").innerHTML = "Dislikes " + dislikes;
            disliked = 0;
            beoordeling = 0;
            console.log("beoordeling = " + beoordeling);
            document.getElementById("downniffo").src = "img/downniffo-unclicked.png";
        }
        $.ajax({
                method: "POST",
                dataType: "json",
                url: "config/sendlikesystem.php",
                data: { videoid: videoid, gebruikerid: gebruikerid, beoordeling: beoordeling}
        })
    }
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
