<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

	error_reporting( ~E_NOTICE );
	
	require_once 'dbconfig1.php';
	

	
	
	if(isset($_POST['btn_save_updates']))
	{
		$username = $_POST['user_name'];// user name
		$userjob = $_POST['user_job'];// user email
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'user_images/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000 )
				{
					//unlink($upload_dir.$edit_row['userPic']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['userPic']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt1 = $DB_con->prepare('UPDATE tbl_users 
									     SET userName=:uname, 
										     userProfession=:ujob, 
										     userPic=:upic 
								       WHERE userID=:uid');
			$stmt1->bindParam(':uname',$username);
			$stmt1->bindParam(':ujob',$userjob);
			$stmt1->bindParam(':upic',$userpic);
			$stmt1->bindParam(':uid',$id);
				
			if($stmt1->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='index.php';
				</script>
                <?php
			}
			/*elseif(!isset($errMSG) && $userPic=null){
				$stmt1 = $DB_con->prepare('INSERT INTO tbl_users(userName,userProfession,userPic) VALUES(:uname, :ujob, :upic)');
			    $stmt1->bindParam(':uname',$username);
			    $stmt1->bindParam(':ujob',$userjob);
			    $stmt1->bindParam(':upic',$userpic);
			
			    if($stmt1->execute())
			    {
				    $successMSG = "new record succesfully inserted ...";
				    header("refresh:5;index.php"); // redirects image view page after 5 seconds.
			    }
			    else
			    {
				    $errMSG = "error while inserting....";
			    }
			}*/
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		
		}
		
						
	}
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row['userName']; ?></title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" media="screen">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

<!-- custom stylesheet -->
<link rel="stylesheet" href="assets/styles.css" media="screen">

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<!--<script src="jquery-1.11.3-jquery.min.js"></script>-->
</head>
<body>
<div class="container1">


	<div class="page-header">
    	<h1 class="h2">update profile. <!--<a class="btn btn-default" href="index.php"> all members </a>--></h1>
    </div>

    <div class="clearfix"></div>

    <form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Username</label></td>
        <td><input class="form-control" type="text" name="user_name" value="<?php echo $userName; ?>"  /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Profession</label></td>
        <td><input class="form-control" type="text" name="user_job" value="<?php echo $userProfession; ?>"  /></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Profile Img</label></td>
        <td>
        	<p><img src="user_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image" accept="image/*" />
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
    </form>

    <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Member Home</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> 
								<?php echo $row['userName']; ?> <i class="caret"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="logout.php">Logout</a>
										<a tabindex="-1" href="p0.php">profile</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="http://localhost:8080/hc1/chat.php">gossip!</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Tutorials <b class="caret"></b>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
	</div>	
	<!--star-->
	<div id="star">
		<script language="javascript" type="text/javascript" src="libraries/p5.js"></script>
		<script language="javascript" type="text/javascript" src="libraries/p5.dom.js"></script>
		<script language="javascript" type="text/javascript" src="sketch.js"></script>
		<script language="javascript" type="text/javascript" src="edge.js"></script>
		<script language="javascript" type="text/javascript" src="hankin.js"></script>
		<script language="javascript" type="text/javascript" src="polygon.js"></script>
	</div>	
	<!--/.fluid-container-->
        <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/scripts.js"></script>
		
  </body>
</html>