<?php

	include 'connectdb.php';

	include 'header.php';
	
	session_start();
	
	$username = "";
	
	$profile_photo = "";
	
	$label = "";
	
	$content = "";
	
	if(array_key_exists("user_id", $_COOKIE)) {
		
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		
	}
	
	if(!array_key_exists("user_id", $_SESSION)) {
		
		header("Location: login.php");
		
		exit();
		
	} else {
		
		echo "<p>Logged In! <a href='index.php?logout=1'>Log out</a></p>";
		
		$user_id = $_SESSION['user_id'];
		
		$query = "SELECT * FROM photo WHERE user_id = '$user_id';";
		
		$result = mysqli_query($con, $query);
		
		if(mysqli_num_rows($result) > 0) {
			
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$content.= "	
					<div class='col-md-3 col-sm-6'>
					
						<div class='thumbnail'>
						
							<a href='background.jpg".$row['image_path']."'><img src='".$row['image_path']."'></a>
							
							<div class='caption'>
							
								<h4>".$row['caption']."</h4>
								
							</div>
							
						</div>
						
					</div>";
					
            }			
			
		}
		
		$query = "SELECT * FROM user WHERE user_id = '$user_id';";
		
		$result = mysqli_query($con, $query);
		
		if(mysqli_num_rows($result) > 0) {
			
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$profile_photo = $row['profile_photo'];
				
				$username = $row['username'];
				
				$label = $row['label'];
				
			}
			
		}
	}

?>

<div class="container">

	<div class="row">
	
		<div class="col-md-4 text-center">
		
			<img src="<?php echo $profile_photo; ?>" alt="Profile photo" class="img-circle profile_photo">
			
		</div>
		
	    <div class="col-md-8">
		
			<h4><?php echo $username; ?></h4>
			
			<p><?php echo $label; ?></p>
		
		</div>
		
		
	</div>

	<div class="row text-center">
	
		<?php echo $content; ?>
		
	</div>
	
	<a href="posts.php">Add new post</a>

</div>	

<?php
	
	include	'footer.php';

?>
