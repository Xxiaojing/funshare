<?php

	include dirname(__DIR__).'/funshare/global/connectdb.php';

	function uploadFile($fileName, $postContent, $user_id, $currentTime, $con) {
		
		$msg = "";
		
		// truncate to get the file name
		$name = basename($_FILES[$fileName]['name']);
		
		// get the extension of the file
		$extention = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		
		// define the allowed format of files
		$allowedFormat = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'mpg', 'flv');
		
		// allowed image formate
		$imgFormat=array('jpg', 'jpeg', 'png', 'gif');
		
		// allowed video format
		$videoFormat=array('mp4', 'avi', 'mov', 'mpg', 'flv');
		
		// the path to store the uploaded image
		$image_path = "image/".$name;
		
		// Get all the submitted data from the form
		$text = $postContent;
			
		if(!in_array($extention, $allowedFormat)) {
			
			echo 'The file format is not allowed. Try another one again.';
			
		} else {
		
			// prepare sql and bind parameters
			$sql = "INSERT INTO `photo`(`user_id`, `caption`, `image_path`, `date_created`, `date_updated`) VALUES ($user_id, '$name', '$image_path', '$currentTime', '$currentTime')";
			
			// stores the submitted data into the database table: photo
			if(mysqli_query($con, $sql)) {
				
				// Now let's move the uploaded image into the folder: image{
				if(move_uploaded_file($_FILES[$fileName]['tmp_name'], $image_path)) {
					
					$msg .= "Image uploaded successfully";
				
					// Insert post for the uploaded image to database
					$last_id = mysqli_insert_id($con);
					
					$sql = "INSERT INTO `posts`(`user_id`, `photo_id`, `post_content`, `date_created`) VALUES ($user_id, $last_id, '$text', '$currentTime')";
			
					// stores the submitted data into the database table: photo
					if(mysqli_query($con, $sql)) {
						
						$msg .= " Post uploaded successfully";
						
					} else {
						
						$msg .= "There was a problem uploading post";
						
					}
				
				} else {
					
					$msg .= "There was a problem uploading image";
					
				}					
				
			} else {
				
				$msg .= "There's an error to upload your file. ";

			}		

			echo $msg;			
			
		}
	
	}
	
?>		