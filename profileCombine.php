<?php

	include dirname(__DIR__).'/funshare/global/connectdb.php';

	include dirname(__DIR__).'/funshare/global/header.php';
	
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
		
		echo "<p>Logged In! <a href='login.php?logout=1'>Log out</a></p>";
		
		$user_id = $_SESSION['user_id'];
		
		$query = "SELECT * FROM photo WHERE user_id = '$user_id';";
		
		$result = mysqli_query($con, $query);
		
		if(mysqli_num_rows($result) > 0) {
			
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$content.= 
					
                    '<div class="row">
                        <div class="col-sm-12">
						
                            <div class="col-sm-10 well well-sm">
                                <p class="text-left">'.$row['caption'].'</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img src="'.$row['image_path'].'" class="img-responsive center-block" alt="Avatar">
                                    </div>
                                    <div class="col-sm-6">
                                        <img src="'.$row['image_path'].'" class="img-responsive center-block" alt="Avatar">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br>
                                        <p class="text-left">
                                            <span><i class="glyphicon glyphicon-heart-empty"></i></span>
                                            <span class="text-primary">Person1</span>, 
                                            <span class="text-primary">Person2</span>, 
                                            <span class="text-primary">Person3</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-left"><span class="text-primary">Person1: </span>Hahahahahah! 23333333333!</p>
                                        <p class="text-left"><span class="text-primary">Person2: </span>Hehehehehehe!</p>
                                    </div>
                                </div>

                                <div class="input-group"> 
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-sm" type="submit"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                                    </div>
                                    <input type="text" class="form-control input-sm" placeholder="Comment..." />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-sm" type="submit"><i class="glyphicon glyphicon-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';					
					
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
  
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-3" id="leftWidth">
                    <div class="affix" id="leftSideBar">
                        <div class="well">
                            <div class="well">
                                <p><a href="#">My Profile</a></p>
                                <img src="<?php echo $profile_photo; ?>" class="img-circle" height="65" width="65" alt="Avatar">
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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default text-left">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <textarea name="Moment" placeholder="Write Your Moment Here" class="form-control"></textarea>
                                    </div>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-sm">Add Photo</button>
                                        <button type="button" class="btn btn-primary btn-sm">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
					<?php echo $content; ?>
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
		
<?php
	
	include	dirname(__DIR__).'/funshare/global/footer.php';

?>
		