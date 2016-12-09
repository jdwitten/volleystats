<?php
if(session_status() !== PHP_SESSION_ACTIVE ){
  session_start();
}

function check_password($username, $password) {
  /*
  $servername = "classroom.cs.unc.edu";
  $username = "tjamesa";
  $password = "Dunkindonuts#22";
  $db = "tjamesadb";
  $conn = new mysqli($servername, $username, $password);

  $trialhash = md5($username."-salt".$password);
  $user = $conn->query("SELECT uid FROM user WHERE userName=".$uname."AND password".$trialhash."");
  return isset($user);
*/
  return true;
}

function login($username, $password)
{

if (check_password($username, $password)) {

  // Generate authorization cookie
  $_SESSION['username'] = $username;
  $_SESSION['authsalt'] = time();

  $auth_cookie_val = md5($_SESSION['username'] . $_SERVER['REMOTE_ADDR'] . $_SESSION['authsalt']);
  setcookie('VOLLEYSTATSAUTH', $auth_cookie_val);
  return true;
  
} else {
  unset($_SESSION['username']);
  unset($_SESSION['authsalt']);

  return false;
}

}
?>