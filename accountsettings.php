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
		Account settings
	</title>
</head>
<body>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["username"])))
		{
			echo "Please enter a username";
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
						echo "This username has already been taken.";
					}
					else
					{
						$username = trim($_POST["username"]);
					}
				}
				else
				{
					echo "Oops, something went wrong. Please try again later";
				}
			}

			//close statement
			mysqli_stmt_close($stmt);
		}


		if(empty(trim($_POST["email"])))
		{
			echo "Please enter a email";
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
						echo "This email has already been taken.";
					}
					else
					{
						$email = trim($_POST["email"]);
					}
				}
				else
				{
					echo "Oops, something went wrong. Please try again later";
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
				echo "Account has been updated";
				header("location: index.php");
			}
			else
			{
				echo "Something went wrong.";
			}
			mysqli_stmt_close($stmt);
		}
		else
		{
			echo "something went horribly wrong......";
		}

	}
	mysqli_close($conn);

	?>
	<div class="flex-container">
		<form action="accountsettings.php" method="POST">
			<div class="flex-item"><input class="changeitems" placeholder="Username" type="text" name="username" value="<?php echo $usernamesession ?>"></div>
			<div class="flex-item"><input class="changeitems" placeholder="Email" type="text" name="email" value="<?php echo $email ?>"></div>
			<div class="flex-item"><input class="changebutton" type="submit" name="submit" value="Change"></div>
			<div class="flex-item">
				Back to <a href="index.php">home</a>
			</div>
		</form>
	</div>
</body>
</html>
