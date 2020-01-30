<?php
      $connect = mysqli_connect("localhost", "root", "", "niffoflix");
      $timestamp = $_POST["timestamp"];
      $gebruikerid = $_POST["gebruikerid"];
      $videoid = $_POST["videoid"];
      if(isset($timestamp)){
        round($timestamp);
        $sql = "SELECT tijdstip FROM kijksessie WHERE gebruikerid = ? && videoid = ?";
        if($stmt = mysqli_prepare($connect, $sql)){ 
          mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
          if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_fetch($stmt);
            if(mysqli_stmt_num_rows($stmt) == 0){
              mysqli_stmt_close($stmt);
              $sql = "INSERT INTO kijksessie VALUES(?, ?, ?)";
              if($stmt = mysqli_prepare($connect, $sql)){
                mysqli_stmt_bind_param($stmt, "iii", $gebruikerid, $videoid, $timestamp);
                if(mysqli_stmt_execute($stmt)){
                  setcookie("timestamp", "", time() - 1);
                }
                else{
                  echo mysqli_error($connect);
                }
              }
              else{
                echo mysqli_error($connect);
              }
              mysqli_stmt_close($stmt);
            }
            else{
              mysqli_stmt_close($stmt);
              $sql = "UPDATE kijksessie SET tijdstip = ? WHERE gebruikerid = ? && videoid = ?";
              if($stmt = mysqli_prepare($connect, $sql)){
                mysqli_stmt_bind_param($stmt, "iii", $timestamp, $gebruikerid, $videoid);
                if(mysqli_stmt_execute($stmt)){
                  setcookie("timestamp", "", time() - 1);
                }
                else{
                  echo mysqli_error($connect);
                }
              }
              else{
                echo mysqli_error($connect);
              }
              mysqli_stmt_close($stmt);
            }
          }
          else{
            mysqli_error($connect);
          }
        }
        else{
          echo mysqli_error($connect);
        }
      }
    ?>
