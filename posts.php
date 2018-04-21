<?php

	include 'connectdb.php';
	
	session_start();
	
	$msg = "";

	if(array_key_exists("user_id", $_COOKIE)) {
		
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		
	}
	
	if(!array_key_exists("user_id", $_SESSION)) {
		
		header("Location: login.php");
		
		exit();
		
	} else {
		
		// if upload button is pressed
		if(isset($_POST['submit']) && isset($_FILES['photoPost']['name'])) {
		
			// the path to store the uploaded image
			$name = basename($_FILES['photoPost']['name']);
			
			$image_path = "image/".$name;
			
			$user_id = $_SESSION['user_id'];
			
			// Get all the submitted data from the form
			$text = $_POST['makePost'];
			
			$sql = "INSERT INTO photo (user_id, caption, image_path) VALUES ('$user_id', '$name', '$image_path')";
			
			// stores the submitted data into the database table: photo
			if(mysqli_query($con, $sql)) {
				
				
			} else {
				
			}
			
			
			// Now let's move the uploaded image into the folder: image
			if(move_uploaded_file($_FILES['photoPost']['tmp_name'], $image_path)) {
				
				$msg = "Image uploaded successfully";
				
			} else {
				
				$msg = "There was a problem uploading image";
				
			}
		}
		
	}	

?>



<?php

	include 'header.php';
	
?>

<div class="container">

	<h1>Create a New Post</h1>

	<form action="posts.php" method="POST" enctype="multipart/form-data">

		<div class="form-group">
		
			<label for="makePost">Make post</label>
			
			<textarea class="form-control" id="makePost" name="makePost" rows="3" placeholder="What's on your mind?"></textarea>
			
		</div>
		
		<div class="form-group">
			
			<input type="file" class="form-control-file" id="photoPost" name="photoPost">
			
		</div>
		
		<input type="submit" id="postID" name="submit" value="Submit">

	</form>

	<a href="homepage.php">Go back</a>

</div>

<?php

	include 'footer.php';
	
?>