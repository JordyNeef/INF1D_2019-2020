<?php
	//checkt of je ingelogd bent
	session_start();
	if(isset($_SESSION["login"])){
		header("location:index.php");
	}
	// Include connection file
	require_once "config/conn.php";

	// Define variables and initialize with empty values
	$username = $password = $confirm_password = $email = "";
	$username_err = $password_err = $confirm_password_err = $email_err = "";

	// Processing from data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		// Validate username
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter a username ";
			echo $username_err;
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
						$username_err = "This username is already taken ";
						echo $username_err;
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
						echo $email_err;
					}
					else{
						$email = trim($_POST["email"]);
					}
					// Close statement
				mysqli_stmt_close($stmt);
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}	
		}

		// Validate password
		if(empty(trim($_POST["password"]))){
	        $password_err = "Please enter a password ";   
	        echo $password_err;
	    } 
	    elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "Password must have atleast 6 characters ";
	        echo $password_err;
	    } 
	    else{
	        $password = trim($_POST["password"]);
	    }
	    
	    // Validate confirm password
	    if(empty(trim($_POST["confirm_password"]))){
	        $confirm_password_err = "Please confirm password ";   
	        echo $confirm_password_err;  
	    } 
	    else{
	        $confirm_password = trim($_POST["confirm_password"]);
	        if(empty($password_err) && ($password != $confirm_password)){
	            $confirm_password_err = "Password did not match. ";
	            echo $confirm_password_err;
	        }
	    }

	    // Validate trial version
	    if (isset($_POST['submit'])) {
			$proefversie=$_POST['proefversie'];
		}

	    // The user may only upload .png or .jpg or .jpeg files and the file size must be under 600 kb:
	    // Check on the extension and file size
	    if ((($_FILES["uploadedFile"]["type"] == "image/jpg") || ($_FILES["uploadedFile"]["type"] == "image/jpeg") || ($_FILES["uploadedFile"]["type"] == "image/png")) && ($_FILES["uploadedFile"]["size"] < 600000))
	    {
	        if ($_FILES["uploadedFile"]["error"] > 0)
	        {
	            echo "Return Code: " . $_FILES["uploadedFile"]["error"];
	        } 
	        else
	        {
	            // Checks if the file already exists, if it does not, it copies the file to the specified folder.
	            if (file_exists("img/avatar/" . $_FILES["uploadedFile"]["name"]))
	            {
	                echo $_FILES["uploadedFile"]["name"] . " already exists. ";
	            } 
	            else
	            {
	            	$userimagepath = $_FILES["uploadedFile"]["name"];
	                move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], "img/avatar/" . $_FILES["uploadedFile"]["name"]);
	            }
	        }
	    } 
	    else
	    {
	        echo "Invalid file";
	        $userimagepath = "account.png";
	    }

	    // !!Alleen bestandsnaam wordt opgeslagen, die de mappen waar die in zit

	    // Check input errors before inserting in database
	    if(empty($username_err) && empty($email_err) && empty($password_err)){

	    	//Prepare insert statement
	    	$sql = "INSERT INTO gebruiker (gebruikersnaam, mail, wachtwoord, proefversie, userimagepath) VALUES (?, ?, ?, $proefversie, ?)";

	    	if($stmt = mysqli_prepare($conn, $sql)){
	    		// Bind variables to the prepared statement as parameters
	    		mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_email, $param_password, $param_userimagepath);

	    		// Set parameters
	    		$param_username = $username;
	    		$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
	    		$param_userimagepath = $userimagepath;

	    		// Attempt to execute the prepared statement
	    		if(mysqli_stmt_execute($stmt)){
	    			// Redirect to login page
	    			header("location: login.php");
	    		}
	    		else{
	    			echo "Something went wrong. Please try again later.";
	    		}
				 // Close connection
				 mysqli_close($conn);
	    	}else{
				echo "qeury werkt niet";
			}
	
	    }

	   
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
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
				<div class="flex-item"><input class="changeitems" placeholder="Username" type="text" name="username" /></div>
				<div class="flex-item"><input class="changeitems" placeholder="Email" type="text" name="email" /></div>
				<div class="flex-item"><input class="changeitems" placeholder="Password" type="password" name="password" /></div>
				<div class="flex-item"><input class="changeitems" placeholder="Confirm password" type="password" name="confirm_password" /></div>
				<div class="flex-item">
					I would like a trial version
					<input class="radiobuttons" type="radio" name="proefversie" value="1" checked="checked">Yes</input>
					<input class="radiobuttons" type="radio" name="proefversie" value="0">No</input>
				</div>
				<div class="flex-item">
					Add your own avatar:
					<input class="file" type="file" name="uploadedFile" />
				</div>
				<div class="flex-item"><input class="submitbutton" type="submit" name="submit" value="Submit" /></div>
				<div class="flex-item">
					Already have an account? <a href="login.php">Log in</a>
				</div>
			</form>
		</div>
	</body>
</html>
