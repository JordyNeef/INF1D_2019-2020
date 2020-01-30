<?php
      $connect = mysqli_connect("localhost", "root", "", "niffoflix");
      //update de beoordeling als die wordt veranderd maar wel in de database staat
      $timestamp = $_POST["timestamp"];
      $gebruikerid = $_POST["gebruikerid"];
      $videoid = $_POST["videoid"];
            //checkt of de timestamp is geset
      if(isset($timestamp)){
        // rond de timestamp af
        round($timestamp);
        //checkt of er al een timestamp in de database staat die overeen komt met de videoid van de video en de gebruikerid van de gebruiker
        $sql = "SELECT tijdstip FROM kijksessie WHERE gebruikerid = ? && videoid = ?";
        if($stmt = mysqli_prepare($connect, $sql)){ 
          mysqli_stmt_bind_param($stmt, "ii", $gebruikerid, $videoid);
          if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_fetch($stmt);
            //  checkt of hij resultaten krijgt
            if(mysqli_stmt_num_rows($stmt) == 0){
              mysqli_stmt_close($stmt);
              // voegt de timestamp toe aan de database
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
              // update de timestamp als deze al in de database staat
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
