<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "niffoflix";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn-> connect_error) {
        die("Connectie mislukt: " . $conn-> connect_error);
    }
?>