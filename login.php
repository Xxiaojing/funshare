<?php

	include 'connectdb.php';
	
	session_start();
	
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
/*
		if (empty($_POST["username"])) {
			
			$usernameERR = "Username is Required";
			
		} else {
			
			$username = test_input($_POST["username"]);
			
		}
*/
		if (empty($_POST["password"])) {
			
			$passwordERR = "Password is Required";
			
		} else {
			
			$password = test_input($_POST["password"]);
			
		}

		if (empty($emailERR) && empty($usernameERR) && empty($passwordERR)) {
			
			$email = mysqli_real_escape_string($con, $email);

			$query = "SELECT * FROM user WHERE email = '$email'";
			
			$result = mysqli_query($con, $query);
			
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			if(isset($row)) {	
			
				if(password_verify($password, $row['salted_password'])) {
					
					$_SESSION['user_id'] = $row['user_id'];
					
					if($_POST['stayLoggedIn'] == '1') {
						
						setcookie("user_id", $row['user_id'], time() + 60*60*24*365);
						
					}
					
					header("Location: homepage.php");
					
				} else {
					
					$error = "That email/password combination could not be found.";
					
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
						
							<small id="passwordHelp" class="text-danger">* <?php echo $emailERR; ?></small>     
							
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
						
							<input class="btn btn-success" type="submit" id="submit" name="submit" value="Log in">
						
							<p class="text-danger"><?php echo $error; ?></p>
						
						</fieldset>
				
						<p>Don't have an account?<a href="index.php"> Sign up</a></p>
				
					</div>
					
				</form>
				
			</div>
		
		</div>
		
	</body>	
		
	<?php include 'footer.php'; ?>
	
</html>		