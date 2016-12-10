<?php
if(session_status() !== PHP_SESSION_ACTIVE ){
  session_start();
}
include_once "DataInterface.php";
include_once("login.php");

$data = new DataInterface();

if($_POST){
  unset($_SESSION['errors']);
  $fname = $_POST['first_name'];
  $lname = $_POST['last_name'];
  $uname = $_POST['username'];
  $pass = $_POST['password'];
  $email = $_POST['email'];

  //check post data for valid fields
  if(strlen($fname) < 1 || strlen($fname) > 40){
    $_SESSION['errors']['first_name'] = "Invalid input";
  }
  if(strlen($lname) < 1 || strlen($lname) > 40){
    $_SESSION['errors']['last_name'] = "Invalid input";
  }
  if(strlen($uname) < 1 || strlen($uname) > 40){
    $_SESSION['errors']['username'] = "Invalid input";
  }
  if(strlen($pass) < 1 || strlen($pass) > 40){
    $_SESSION['errors']['password'] = "Invalid password";
  }
  if(strlen($email) < 1 || strlen($email) > 40){
    $_SESSION['errors']['email'] = "Invalid email";
  }

  if(isset($_SESSION['errors']) && count($_SESSION['errors'])>0){
    $get_string = "?success=false";
  }
  else{
    $user = $data->createUser($_POST['first_name'], $_POST['last_name'], $_POST['username'],
                             $_POST['password'], $_POST['email']);
    if(is_null($user)){
      $_SESSION['errors']['general'] = "Oops! Something went wrong please try again!";
      $get_string = "?success=false";
    }
    else{
      if(login($_POST["username"], $_POST["password"])){
          $get_string = "?success=true";
      }else{
          $get_string = "?success=false";
      }
    }
  }
  unset($_POST);
  header("Location: ".$_SERVER['REQUEST_URI'].$get_string);
  exit();
}



if(count($_GET)>0 && $_GET['success']=="true"){
  
  $success = true;
  $fname_error = "";
  $lname_error = "";
  $username_error = "";
  $password_error = "";
  $email_error = "";

}


elseif(count($_GET)>0 && $_GET['success']==="false"){

  if(isset($_SESSION['errors']['first_name'])){
    $fname_error = $_SESSION['errors']['first_name'];
  }else{
    $fname_error = "";
  }

  if(isset($_SESSION['errors']['last_name'])){
    $lname_error = $_SESSION['errors']['last_name'];
  }else{ 
    $lname_error = "";
  }

  if(isset($_SESSION['errors']['username'])){
    $username_error = $_SESSION['errors']['username'];
  }else{
    $username_error = "";
  }

  if(isset($_SESSION['errors']['password'])){
    $password_error = $_SESSION['errors']['password'];
  }else{
    $password_error = "";
  }

  if(isset($_SESSION['errors']['email'])){
    $email_error = $_SESSION['errors']['email'];
  }else{
    $email_error = "";
  }
}

else{
  $fname_error = "";
  $lname_error = "";
  $username_error = "";
  $password_error = "";
  $email_error = "";
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<title>Parallax Template - Materialize</title>

  <!-- CSS  -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="css/materialize.css" type="text/css" rel="stylesheet"/>
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="controller.js"></script>
</head>
<body>';

if(isset($success) && $success){
echo '<div class = "container"><h1 class="blue-text text-lighten-1">Congratulations you are registered!</h1>
<div class="row">
  <a href = "stats.php"><div class="col s6" class="blue-text text-lighten-1">Get Started!</div></a>
</div>
</div>';
}
else{
echo '<div class="container"><h1 class="blue-text text-lighten-1">Create an Account:</h1>
  <div class="row"><form class="col s12" action = "signup.php" method="post">
    <div class="row">
      <div class="input-field col s6">
        <label for="first_name">First Name</label>
        <input  id="first_name" type="text" class="validate" name="first_name">
          <p>'.$fname_error.'</p>
      </div>
        <div class="input-field col s6">
          <input type="text" class="validate" name="last_name">
          <label for="last_name">Last Name</label>
          <p>'.$lname_error.'</p>
        </div>
      </div>
      <div class="row">
       	
      </div>
      <div class="row">
      	<div class="input-field col s6">
          <input id="username" type="text" class="validate" name="username">
          <label for="username">Username</label>
          <p> '.$username_error.'</p>
        </div>
        <div class="input-field col s6">
          <input id="password" type="password" class="validate" name="password">
          <label for="password">Password</label>
          <p>'.$password_error.'</p>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" class="validate" name="email">
          <label for="email">Email</label>
          <p>'.$email_error.'</p>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Submit
   			 <i class="material-icons right">send</i>
  		</button>
    </form>
  </div>
	</div>';
}
echo '</body></html>';
?>