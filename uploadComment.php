<?php

	include dirname(__DIR__).'/funshare/global/connectdb.php';

	function uploadComment($photoName, $commentContent, $photo_id, $user_id, $currentTime, $con) {
		
		$msg = "";
		
		// truncate to get the file name
		$name = basename($_FILES[$photoName]['name']);
		
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
		$text = $commentContent;
			
		if(!in_array($extention, $allowedFormat)) {
			
			echo 'The file format is not allowed. Try another one again.';
			
		} else {

			// prepare sql
			$sql="INSERT INTO comment (`comment`, `user_id`, `photo_id`, `date_created`) VALUES ('$text','$user_id','$photo_id','$currentTime')";
			
			// stores the submitted data into the database table: comment
			if(mysqli_query($con, $sql)) {

				$msg = " Post uploaded successfully";
				
				// Insert post for the uploaded image to database
				$last_id = mysqli_insert_id($con);
				
				$sql="INSERT INTO photo_comment (`comment_id`, `photo_path`, `date_created`) VALUES ($last_id,'$image_path','$currentTime')";
				//$sql = "INSERT INTO `posts`(`user_id`, `photo_id`, `post_content`, `date_created`) VALUES ($last_id, $user_id, '$text', '$currentTime')";
		
				// stores the submitted data into the database table: photo
				if(mysqli_query($con, $sql)) {
				
					// Now let's move the uploaded image into the folder: image{
					if(move_uploaded_file($_FILES[$photoName]['tmp_name'], $image_path)) {
						
						$msg .= "Image uploaded successfully";
					
					
					} else {
						
						$msg .= "There was a problem uploading image";
						
					}					
					
				} else {
					
					$msg .= "There was a problem uploading post";
					
				}						
				
			} else {
				
				$msg .= "There's an error to upload your file. ";

			}		

			echo $msg;			
			
		}
	
	}
	
?>		