<?php
session_start();
//checkt of je ingelogd bent
if(isset($_SESSION["login"])){
    //sessies definen
    $id = $_SESSION["ID"];
    $username = $_SESSION["username"];
    $admin = $_SESSION["admin"];
    $proefversie = $_SESSION["proefversie"];
    $profilepic = $_SESSION["profilepic"];
    $email = $_SESSION["email"];
} 
?>
