	<?php
		include("config/conn.php");
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
			$query=    "SELECT gebruikersnaam, wachtwoord 
						FROM gebruiker
						WHERE gebruikersnaam = Koen"; 
			// or die("Password and or Username are incorrect.".mysqli_error($conn));
		

			if($stmt=mysqli_prepare($conn, $query)) 
			{
				mysqli_bind_param($stmt, "s", $username);
				if(mysqli_stmt_execute($stmt))
				{
					mysqli_bind_stmt_result($stmt, $usernameDB, $passwordDB);
					mysqli_stmt_fetch($stmt);
					if(password_verify($password, $passwordDB))
					{
						header("location: index.php");
					}
					else
					{
						echo "Password does not match Username.";
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