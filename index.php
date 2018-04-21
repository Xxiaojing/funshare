 <?php

	include 'connectdb.php';
	
	session_start();

	if(array_key_exists("logout", $_GET)) {
		
		unset($_SESSION);
		
		setcookie("user_id", "", time() - 60*60);
		
		$_COOKIE["user_id"] = "";
		
		session_destroy();
		
	} else if((array_key_exists("user_id", $_SESSION) AND $_SESSION['user_id']) OR (array_key_exists("user_id", $_COOKIE) AND $_COOKIE['user_id'])) {
		
		header("Location: homepage.php");
		
	}

		
	$emailERR = "";
	
	$usernameERR = "";
	
	$passwordERR = "";
	
	$error = "";
	
	$email = "";
	
	$username = "";
	
	$password = "";	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (empty($_POST["email"])) {
			
			$emailERR = "Email is Required";
			
		} else {
			
			$email = test_input($_POST["email"]);
			
		}

		if (empty($_POST["username"])) {
			
			$usernameERR = "Username is Required";
			
		} else {
			
			$username = test_input($_POST["username"]);
			
		}

		if (empty($_POST["password"])) {
			
			$passwordERR = "Password is Required";
			
		} else {
			
			$password = test_input($_POST["password"]);
			
		}

		// type in password again
		if (empty($emailERR) && empty($usernameERR) && empty($passwordERR)) {
			
			$email = mysqli_real_escape_string($con, $email);
	
			$emailQuery = "SELECT user_id FROM user WHERE email = '$email';";
			
			$emailRes = mysqli_query($con, $emailQuery);

			$username = mysqli_real_escape_string($con, $username);
			
			$usernameQuery = "SELECT user_id FROM user WHERE username = '$username';";
			
			$usernameRes = mysqli_query($con, $usernameQuery);
			
			if(mysqli_num_rows($emailRes) > 0) {
				
				$emailERR = "That email address is taken.";
				
			} else if(mysqli_num_rows($usernameRes) > 0) {
				
				$usernameERR = "That username is taken.";
				
			}else {
				
				$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
				
				$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
				
				$password = password_hash($password, PASSWORD_BCRYPT);
				
				$currentTime = date("Y-m-d h:i:sa");
				 
				//need to insert current time to table
				$query = "INSERT INTO user (email, first_name, last_name, username, salted_password, date_created) VALUES ('$email', '$firstname', '$lastname', '$username', '$password', '$currentTime');";
				
				if(!mysqli_query($con, $query)) {
					
					$error = "<p>Could not sign you up - please try again later.</p>";
					
				} else {
					
					$_SESSION['user_id'] = mysqli_insert_id($con);
					
					$_SESSION['username'] = $username;
					
					$_SESSION['user_email'] = $email;
					
					if($_POST['stayLoggedIn'] == '1') {
						
						setcookie("user_id", mysqli_insert_id($con), time() + 60*60*24*365);
					}
					
					header("Location: homepage.php");
					
				}
			}
			
		} 
		
	}

	function test_input($data) {
		
		$data = trim($data);
		
		$data = stripslashes($data);
		
		$data = htmlspecialchars($data);
		
		return $data;
		
	}	
	
?>

<!DOCTYPE html>
<html>

	<?php include 'header.php'; ?>
		
	<?php include 'cover.php'; ?>
	
    <body>	

		<div class="container">	
			
			<div class="col-md-8 col-md-offset-2">			
			
				<div class="text-center">
				
					<h1>Fun Share</h1>
				
					<div class="text-center">
					
						<p><span class="text-danger">* required field.</span></p>	
						
					</div>
				
				</div>
				
				<form id="user_info" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">			
				
					<div class="form-group row">
					
						<label for="email" class="col-sm-3 col-form-label text-success">Email</label>
						
						<div class="col-sm-6">
							
							<input class="form-control is-valid" type="email" id="email" name="email" placeholder="Your Email">
								
						</div>
						
						<div class="col-sm-3">
						
							<small id="emailHelp" class="text-danger">* <?php echo $emailERR; ?></small>     
							
						</div>					
							
					</div>
					
					<div class="form-group row">
					
						<label for="firstname" class="col-sm-3 col-form-label text-success">First Name</label>
						
						<div class="col-sm-6">
					
							<input class="form-control is-valid" type="firstname" id="firstname" name="firstname" placeholder="First name">
							
						</div>
					
					</div>

					<div class="form-group row">
					
						<label for="lastname" class="col-sm-3 col-form-label text-success">Last Name</label>
						
						<div class="col-sm-6">
					
							<input class="form-control is-valid" type="lastname" id="lastname" name="lastname" placeholder="Last name">
							
						</div>
					
					</div>
					
					<div class="form-group row">
					
						<label for="username" class="col-sm-3 col-form-label text-success">Username</label>
						
						<div class="col-sm-6">
							
							<input class="form-control is-valid" type="username" id="username" name="username" placeholder="Username">
								
						</div>
						
						<div class="col-sm-3">
						
							<small id="usernameHelp" class="text-danger">* <?php echo $usernameERR; ?></small>     
							
						</div>					
							
					</div>	

					<div class="form-group row">
					
						<label for="password" class="col-sm-3 col-form-label text-success">Password</label>
						
						<div class="col-sm-6">
							
							<input class="form-control is-valid" type="password" id="password" name="password" placeholder="Password">
								
						</div>
						
						<div class="col-sm-3">
						
							<small id="passwordHelp" class="text-danger">* <?php echo $passwordERR; ?></small>     
							
						</div>					
							
					</div>	
					
					<div class="text-center">
					
						<div class="checkbox">
						
							<label>
						
								<input type="checkbox" id="stayLoggedIn" name="stayLoggedIn" value=1>
						
							Stay logged in
							
							</label>
							
						</div>
						
						<fieldset class="form-group">	
						
							<input class="btn btn-success" type="submit" id="submit" name="submit" value="Sign up">
						
							<?php echo $error; ?>
						
						</fieldset>
				
						<p>Have an account?<a href="login.php"> Log in</a></p>
				
					</div>
				
				</form>
	
			</div>
				
		</div>
		
    </body>
	
	<?php include 'footer.php'; ?>
	
</html>







