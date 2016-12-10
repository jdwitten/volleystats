<?php
include_once "DataInterface.php";
if(session_status() !== PHP_SESSION_ACTIVE ){
  session_start();
}


function check_password($uname, $pass) {
  
  $servername = "classroom.cs.unc.edu";
  $username = "tjamesa";
  $password = "Dunkindonuts#22";
  $db = "tjamesadb";
  $conn = new mysqli($servername, $username, $password,$db);
  $trialhash = md5($uname."-salt".$pass);
  $user = $conn->query("SELECT uid FROM User WHERE userName='".$uname."' AND password='".$trialhash."'");
  return $user->num_rows > 0;
}

function login($username, $password)
{
unset($_SESSION['username']);
unset($_SESSION['authsalt']);
if (check_password($username, $password)) {

  // Generate authorization cookie
  $_SESSION['username'] = $username;
  $_SESSION['authsalt'] = time();
  $servername = "classroom.cs.unc.edu";
  $unamedb = "tjamesa";
  $passdb = "Dunkindonuts#22";
  $db = "tjamesadb";
  $conn = new mysqli($servername, $unamedb, $passdb,$db);
  $trialhash = md5($username."-salt".$password);
  $user = $conn->query("SELECT uid FROM User WHERE userName='".$username."' AND password='".$trialhash."'");
  $row = $user->fetch_assoc();
  $id = $row["uid"];
  $data = new DataInterface();
  $_SESSION['current_user'] = $data->getUser(intval($id));
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