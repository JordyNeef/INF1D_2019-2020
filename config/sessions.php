<?php
session_start();
if(isset($_POST["submit"])){
   if(isset($_SESSION["login"])){
       $id = $_SESSION["id"];
       $username = $_SESSION["username"];
       $profilepic = $_SESSION["profilepic"];
       $admin = $_SESSION["admin"];
       $email = $_SESSION["email"];
   } 
}
?>
