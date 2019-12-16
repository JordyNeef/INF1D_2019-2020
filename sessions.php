<?php
session_start();
if(isset($_POST["submit"])){
   if(isset($_SESSION["login"])){
       $_SESSION["id"] = $id;
       $_SESSION["username"] = $username;
       $_SESSION["picture"] = $profilepic;
       $_SESSION["admin"] = $admin;
       $_SESSION["mail"] = $email;
   } 
}
?>
