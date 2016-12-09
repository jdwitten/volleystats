<?php
ini_set('display_errors', 'Off');
include("login.php");
if($_POST){
	if(login($_POST["username"], $_POST["password"])){
		unset($_POST);
		header("Location: stats.php");
		exit();
	}
	else{
		echo("invalid password");
		$error = "Username or Password is invalid please try again";
		unset($_POST);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<title>VolleyStats</title>

  <!-- CSS  -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="css/materialize.css" type="text/css" rel="stylesheet"/>
<link href="style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<script src="js/materialize.js"></script>
</head>
<body>
<form action="login-page.php" method="post">
	 <div class="row">
	 	<div class="col s3"></div>
        <div class="input-field col s6">
          <input id="username" type="text" name="username" class="validate">
          <label for="username">Username</label>
        </div>
        <div class="col s3"></div>
    </div>
    <div class="row">
	 	<div class="col s3"></div>
        <div class="input-field col s6">
          <input id="password" type="text" name="password" class="validate">
          <label for="password">Password</label>
        </div>
        <div class="col s3"></div>
    </div>
     <div class="row">
	 	<div class="col s3"></div>
        <div class="input-field col s6">
        <input type="submit" class="waves-effect waves-light btn">
        </div>
        <div class="col s3"></div>
    </div>
</form>
<h5 id="error" class="red-text"><?php
if(isset($error)){
	echo $error;
}
?>
</h5>


</body>
</html>