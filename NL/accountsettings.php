<!DOCTYPE html>
<html>
<head>
    <?php require 'config/functions.php';?>
    <?php require 'config/conn.php';?>
    <?php 
        if(!isset($_SESSION["login"])){
            header("login.php");
        }
    ?>
	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="stylesheet/main.css" type="text/css"  rel="stylesheet">
	<link href="stylesheet/accountsettings.css" type="text/css"  rel="stylesheet">
	<title>
		gebruikers instellingen
	</title>
</head>
<body>
<div class="flex-container">
		<form action="accountsettings.php" method="POST">
			<div class="flex-item"><input class="changeitems" placeholder="gebruikersnaam" type="text" name="username" value="<?php echo $usernamesession ?>"></div>
			<div class="flex-item"><input class="changeitems" placeholder="Mail" type="text" name="email" value="<?php echo $email ?>"></div>
			<div class="flex-item"><input class="changebutton" type="submit" name="submit" value="verander"></div>
			<div class="flex-item">
				terug naar <a href="index.php">Huis</a>
			</div>
		</form>
	</div>
	<?php
	if(isset($_POST['submit']))
	{
		if(empty(trim($_POST['username'])))
		{
			echo "Vul een gebruikernaam in a.u.b.";
			
		}
		else
		{
			$sql = "SELECT gebruikerid FROM gebruiker WHERE gebruikersnaam = ?";
			if($stmt = mysqli_prepare($conn, $sql))
			{
				//bind variables to the preoared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);

				//set parameters
				$param_username = trim($_POST["username"]);

				//Attempt to exevute the prepared statement
				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						echo "Deze gebruikersnaam is al in gebruik.";
					}
					else
					{
						$username = trim($_POST["username"]);
					}
				}
				else
				{
					echo "Oeps, er ging iets fout. Probeer het later opnieuw a.u.b.";
				}
			}

			//close statement
			mysqli_stmt_close($stmt);
		}


		if(empty(trim($_POST["email"])))
		{
			echo "Vul een mail in a.u.b.";
		}
		else
		{
			$sql = "SELECT gebruikerid FROM gebruiker WHERE mail = ?";
			if($stmt = mysqli_prepare($conn, $sql))
			{
				//bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_email);

				//set parameters
				$param_email = trim($_POST["email"]);

				//Attempt to exevute the prepared statement
				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						echo "deze mail is al in gebruik.";
					}
					else
					{
						$email = trim($_POST["email"]);
					}
				}
				else
				{
					echo "Oeps, er ging iets fout. Probeer het later opnieuw a.u.b.";
				}
			}

			//close statement
			mysqli_stmt_close($stmt);
		}

		$sql = "UPDATE gebruiker SET gebruikersnaam = ?, mail = ? WHERE gebruikerid = ?";

		if($stmt = mysqli_prepare($conn, $sql))
		{
			mysqli_stmt_bind_param($stmt, "ssi", $param_username, $param_email, $id);

			if(mysqli_stmt_execute($stmt))
			{
				echo "de gebruiker is ge-update.";
				header("location: index.php");
			}
			else
			{
				echo "Er ging iets fout.";
			}
			mysqli_stmt_close($stmt);
		}
		else
		{
			echo "Er ging iets heeel erg fout......";
		}

	}
	mysqli_close($conn);
	?>
	
</body>
</html>
