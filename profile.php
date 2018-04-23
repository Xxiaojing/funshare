<?php

	include dirname(__DIR__).'/funshare/global/connectdb.php';
	
	include 'uploadFile.php';
	
	include 'uploadComment.php';
	
	session_start();
	
	$msg = "";

	$user_id = "";
		
	$username = "";
		
	$profile_photo = "";
	
	$posts = "";
	
	$private = "";
	
	$only_friend = "";
	
	if(array_key_exists("user_id", $_COOKIE)) {
		
		$_SESSION['user_id'] = $_COOKIE['user_id'];
		
	}
	
	if(!array_key_exists("user_id", $_SESSION)) {
		
		header("Location: login.php");
		
		exit();
		
	}
			
	$user_id = $_SESSION['user_id'];

	$currentTime = date("Y-m-d h:i:sa");	
	
	// if upload button is pressed
	if(isset($_POST['submit'])) { 

		$value = uploadFile('photoPost', $_POST['makePost'], $user_id, $currentTime, $con);
		
		echo $value;

	}	

	$query = "SELECT * FROM user WHERE user_id =".$_GET['user_id'];
	
	$result = mysqli_query($con, $query);
	
	if(mysqli_num_rows($result) > 0) {
		
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			
			$profile_photo = $row['profile_photo'];
			
			$username = $row['username'];
			
			$private = $row['private'];
			
			$only_friend = $row['only_friend'];
			
		}
		
	}	
							
	// add comment to database				
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commentVar"])) {
		
		$comment_content = "";
		
		$error = "";
		
		$photoName = "";
		
		if(empty($_POST["comment_content"])) {
			
			$error = '<p class="text-danger">Comment is required</p>';
			
		} else {
			
			$comment_content = $_POST["comment_content"];
			
			$photoName = "photoComment";
			
		}
		
		if($error == '') {
		 
			$photo_id=$_POST["commentVar"];
		  
			$value = "";
			
			if(empty($_POST["photoComment"])) {
				
				$query="INSERT INTO comment (`comment`, `user_id`, `photo_id`, `date_created`) VALUES ('$comment_content','$user_id','$photo_id','$currentTime')";
				
				if (!mysqli_query($con,$query)) {
					
					die('Error: ' . mysqli_error($con));
					
				}
				
			} else {
				
				$value = uploadComment($photoName, $comment_content, $photo_id, $user_id, $currentTime, $con);
				
			}
			
		}									
	}
	
	// add likes to database				
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["likeVar"])) {
		
		$photo_id=$_POST["likeVar"];
	  
		$query="UPDATE `photo` SET `likes`=`likes`+1 WHERE photo_id = $photo_id";
		
		if (!mysqli_query($con,$query)) {
			
			die('Error: ' . mysqli_error($con));
			
		}	
		
	}	
							
?>

<!DOCTYPE html>
<html lang="en">

	<?php include dirname(__DIR__).'/funshare/global/header.php'; ?>
  
        <div class="container text-center" style="margin-top:65px;">
		
            <div class="row">
			
                <div class="col-sm-3" id="leftWidth">
				
                    <div class="affix" id="leftSideBar">
					
                        <div class="well">
						
                            <div class="well">
							
                                <p><a href="<?php echo 'profile.php?user_id='.$_GET['user_id']; ?>">My Profile</a></p>
								
                                <img src="<?php echo $profile_photo; ?>" class="img-circle" height="65" width="65" alt="Avatar">
								
								<?php
								
									// if current profile is not mine, show follow button
									
								?>
								
                            </div>
							
                            <div class="well">
							
                                <p><a href="#">Interests</a></p>
								
                                <p>
                                    <span class="label label-default">News</span>
                                    <span class="label label-primary">W3Schools</span>
                                    <span class="label label-success">Labels</span>
                                    <span class="label label-info">Football</span>
                                    <span class="label label-warning">Gaming</span>
                                    <span class="label label-danger">Friends</span>
                                </p>
								
                            </div>
                            <div class="alert alert-success fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p><strong>Ey!</strong></p>
                                    People are looking at your profile. Find out who.
                            </div>
                            <p><a href="#">Link</a></p>
                            <p><a href="#">Link</a></p>
                            <p><a href="#">Link</a></p>
                        </div>
                    </div>
                </div>
        
                <div class="col-sm-7">
				
					<?php 
					
					if($user_id == $_GET['user_id']) { // if current profile is mine, show post area
						
						echo '
					<div class="row">
					
                        <div class="col-sm-12">


							<form action="homepage.php" method="POST" enctype="multipart/form-data" class="panel panel-default text-left">

                                <div class="panel-body">
								
                                    <div class="form-group">
									
                                        <textarea name="makePost" placeholder="What is on your mind?" class="form-control"></textarea>
										
                                    </div>
									
									<div class="form-group">
									
										<input type="file" name="photoPost" />        
										
									</div>
									
									<div class="pull-right">
									
										<input type="submit" id="submit" name="submit" value="Post" class="btn btn-primary btn-sm">
										
									</div>
									
								</div>
								
							</form>													
							
                        </div>
						
                    </div>';
						
					}
					
					?>
            
                    <?php 
					
					if($user_id != $_GET['user_id'] && $private == true) {
						
						echo "Sorry, this account is private.";
						
					} elseif($user_id != $_GET['user_id'] && $only_friend == true) {
						
						echo "Sorry, this account is only friend visible.";
						
					} else {
						
						$query = "SELECT * FROM photo WHERE user_id =".$_GET['user_id'];
						
						$result = mysqli_query($con, $query);
			
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 

							$ext = strtolower(pathinfo($row['caption'], PATHINFO_EXTENSION));

							$video=array('mp4','avi','mov','mpg','flv');
							
							$picture=array('jpg','png','gif');
						
							$query = "SELECT * FROM posts WHERE photo_id = ".$row["photo_id"];
							
							$post = mysqli_query($con, $query);
							
							$post = mysqli_fetch_array($post, MYSQLI_ASSOC);
							
							$query = "SELECT * FROM comment WHERE photo_id = ".$row["photo_id"];
							
							$comments = mysqli_query($con, $query);
						
					?>
					
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-2">
                                <img src="<?php echo $profile_photo; ?>" class="img-circle" height="55" width="55" alt="Avatar">
                                <p><?php echo $username; ?></p>
                            </div>

                            <div class="col-sm-10 well well-sm">
                                <p class="text-left"><?php echo $post["post_content"]; ?></p>
                                <div class="row">
								
                                    <div class="col-sm-12">
										<?php																					
							
											if(in_array( $ext, $picture)) {
												
												echo '<img src="'.$row["image_path"].'" class="img-responsive center-block" alt="Avatar">';
										
											} 
											if(in_array( $ext, $video)) {
												
												echo "<video src='".$row['image_path']."' width='500' height='300' controls></video>";
												
											}
											
										?>
                                    </div>
                                    
                                </div>
								
                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <p class="text-left">
                                            <span><i class="glyphicon glyphicon-heart-empty"></i></span>
                                            <span class="text-primary"><?php echo $row["likes"]; ?></span>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
									<?php 
										while($comment = mysqli_fetch_array($comments, MYSQLI_ASSOC)) {
											
											$sql = "SELECT * FROM user WHERE user_id = ".$comment['user_id'];
											
											$sql = mysqli_query($con, $sql);
											
											$sql = mysqli_fetch_array($sql, MYSQLI_ASSOC);
											
											echo '<p class="text-left"><span class="text-primary">'.$sql['username'].': </span>'.$comment['comment'].'</p>';
											
										}
									?>
                                    </div>
                                </div>

                                <div class="input-group"> 
                                    <div class="input-group-btn">
										<form name="likes" action="homepage.php" method="POST">
											<input type="hidden" name="likeVar" value="" />
											<button class="btn btn-default btn-sm likes" type="submit" name="likes" id="<?php echo $row["photo_id"] ?>"><i class="glyphicon glyphicon-thumbs-up"></i></button>
										</form>
                                    </div>
                                </div>
								
								<form class="form-inline" name="comment" action="homepage.php" method="POST">
										<input type="text" class="form-control input-sm" placeholder="Comment..." name="comment_content" />
										<input type="file" name="photoComment" class="form-control input-sm" />
										<div class="input-group">											
											<input type="hidden" name="commentVar" value="" />
											<button class="btn btn-default btn-sm comment" type="submit" name="comment" id="<?php echo $row["photo_id"] ?>"><i class="glyphicon glyphicon-edit"></i></button>											
										</div>
								</form>
                            </div>
                        </div>
                    </div>
					
					<?php 
							}
						} 
					
					?>
                    
                </div>
                
                <div class="col-sm-2" id="rightWidth">
                    <div class="affix" id="rightSideBar">
                        <div class="well">
                            <div class="thumbnail">
                                <p>Upcoming Events:</p>
                                <img src="img/mig29.jpg" alt="Paris" width="400" height="300">
                                <p><strong>Paris</strong></p>
                                <p>Fri. 27 November 2015</p>
                                <button class="btn btn-primary">Info</button>
                            </div>

                            <div class="well">
                                <p>ADS</p>
                            </div>
                            <div class="well">
                                <p>ADS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
	
	<?php include dirname(__DIR__).'/funshare/global/footer.php'; ?>
	
</html>