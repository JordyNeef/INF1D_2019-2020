<?php
	// Include connection file
	require_once "config/conn.php";

	// Define variables and initialize with empty values
	$username = $password = $confirm_password = $email = "";
	$username_err = $password_err = $confirm_password_err = $email_err = "";

	// Processing from data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		// Validate username
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter a username";
		} 
		else{

			// Prepare a select statement
			$sql = "SELECT gebruikerid FROM gebruiker WHERE gebruikersnaam = ?";

			if($stmt = mysqli_prepare($conn, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);

				// Set parameters
				$param_username = trim($_POST["username"]);

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1){
						$username_err = "This username is already taken";
					}
					else{
						$username = trim($_POST["username"]);
					}
				}
				else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}

		// Validate email
		if(empty(trim($_POST["email"]))){
			$email_err = "Please enter a email";
		} 
		else{

			// Prepare a select statement
			$sql = "SELECT gebruikerid FROM gebruiker WHERE mail = ?";

			if($stmt = mysqli_prepare($conn, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_email);

				// Set parameters
				$param_email = trim($_POST["email"]);

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1){
						$email_err = "This email is already taken";
					}
					else{
						$email = trim($_POST["email"]);
					}
				}
				else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}

		// Validate password
		if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
	    } 
	    elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "Password must have atleast 6 characters.";
	    } 
	    else{
	        $password = trim($_POST["password"]);
	    }
	    
	    // Validate confirm password
	    if(empty(trim($_POST["confirm_password"]))){
	        $confirm_password_err = "Please confirm password.";     
	    } 
	    else{
	        $confirm_password = trim($_POST["confirm_password"]);
	        if(empty($password_err) && ($password != $confirm_password)){
	            $confirm_password_err = "Password did not match.";
	        }
	    }

	    // Check input errors before inserting in database
	    if(empty($username_err) && empty($email_err) && empty($password_err)){

	    	//Prepare insert statement
	    	$sql = "INSERT INTO gebruiker (gebruikersnaam, mail, wachtwoord) VALUES (?, ?, ?)";

	    	if($stmt = mysqli_prepare($conn, $sql)){
	    		// Bind variables to the prepared statement as parameters
	    		mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);

	    		// Set parameters
	    		$param_username = $username;
	    		$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

	    		// Attempt to execute the prepared statement
	    		if(mysqli_stmt_execute($stmt)){
	    			// Redirect to login page
	    			header("location.php");
	    		}
	    		else{
	    			echo "Something went wrong. Please try again later.";
	    		}
	    	}

	    	// Close statement
	    	mysqli_stmt_close($stmt);
	    }

	    // Close connection
	    mysqli_close($conn);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="stylesheet/main.css" type="text/css"  rel="stylesheet">
		<link href="stylesheet/signup.css" type="text/css"  rel="stylesheet">
		<title>
			Sign Up
		</title>
	</head>
	<body>
		<div class="flex-container">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="flex-item"><input class="changeitems" placeholder="Username" type="text" name="username"></div>
				<div class="flex-item"><input class="changeitems" placeholder="Email" type="text" name="email"></div>
				<div class="flex-item"><input class="changeitems" placeholder="Password" type="password" name="password"></div>
				<div class="flex-item"><input class="changeitems" placeholder="Confirm password" type="password" name="confirm_password"></div>
				<div class="flex-item"><input class="changebutton" type="submit" name="submit" value="Submit"></div>
				<div class="flex-item">
					Already have an account? <a href="login.php">Log in</a>
				</div>
			</form>
		</div>
	</body>
</html>
