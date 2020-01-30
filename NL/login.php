	<?php
		include("config/conn.php");
		session_start();
		//checkt of je ingelogd bent
		if(isset($_SESSION["login"])){
			header("location:index.php");
		}
		if(isset($_POST["username"]) AND isset($_POST["password"]))
		{
			// values geven aan de invulbalkjes.
			$username=$_POST["username"];
			$password=$_POST["password"];
			// voorkomen van mysql injections
			$username = stripcslashes($username);
			$password = stripcslashes($password);
			$username = mysqli_real_escape_string($conn, $username);
			$password = mysqli_real_escape_string($conn, $password);
			// hier kijk je of de gebruikersnaam en het ww met elkaar matcht.
			$query=    "SELECT gebruikerid, gebruikersnaam, wachtwoord, admin, proefversie, userimagepath, mail 
						FROM gebruiker
						WHERE gebruikersnaam = ?"; 
			// or die("Password and or Username are incorrect.".mysqli_error($conn));
		

			if($stmt=mysqli_prepare($conn, $query)) 
			{
				mysqli_stmt_bind_param($stmt, "s", $username);
				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_bind_result($stmt, $id, $usernameDB, $passwordDB, $admin, $proefversie, $image, $mail);
					mysqli_stmt_fetch($stmt);
					if(password_verify($password, $passwordDB))
					{
						//sessies aanmaken//
						$_SESSION["login"] = "true";
						$_SESSION["ID"] = $id;
						$_SESSION["username"] = $username; 
						$_SESSION["admin"] = $admin;
						$_SESSION["proefversie"] = $proefversie;
						$_SESSION["profilepic"] = $image; 
						$_SESSION["email"] = $mail;
						header("location:index.php");
					}
					else
					{
						echo "<div class='alert'>
							<span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
							Password does not match Username.
							</div>";
					}
				}
				else
				{
					die("Statement not executed");
				}
				mysqli_stmt_close($stmt);
				
			}
			else
			{
				die("Failed to prepare statement. Error: ".mysqli_error($conn));
			}
			mysqli_close($conn);
		}
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="stylesheet/main.css" type="text/css"  rel="stylesheet">
	<link href="stylesheet/login.css" type="text/css"  rel="stylesheet">
	<title>
		Login
	</title>
</head>

	<body>
		<div id="container">
			<form action="login.php" method="post">
				<div id="logo"><img src="img/logo-wit.png"  alt="Niffoflix"></div>
				<div class="inlogVak"><input placeholder="Username" type="text" name="username"></div>
				<div class="inlogVak"><input placeholder="Password" type="password" name="password"></div>
				<p><div class="loginButton"><input type="submit" name="submit" value="Login"></div></p>
				<div id="signup"><p>  Don't have an account yet? <a href="signup.php"> Sign up</a></p></div> 
			</form>
		</div>

	</body>
</html>
