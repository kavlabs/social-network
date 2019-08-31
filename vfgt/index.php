<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	if($user_login->login($email,$upass))
	{
		$user_login->redirect('home.php');
	}
}
?>


<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>VoteForGt</title>
  
  
  
      <link rel="stylesheet" href="css/style.css">
	  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	  <link rel="icon" href="favicon.ico" type="image/x-icon">
  
</head>

<body>
  <div class="wrapper">
	<div class="container">
		<h1>Welcome</h1><br></br>
		
		<form action="login.php" class="form" method="post">
			<button type="submit" id="login-button" name="login-button">Login</button>
		</form >
		<form action="signup.php" class="form" method="post">	
			<button type="submit" id="signup-button" name="signup-button">SignUp</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <!--<script src="js/index.js"></script>-->

</body>
</html>
