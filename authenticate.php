<?php
if (!isset($_COOKIE['VOLLEYSTATSAUTH']) ||
    ($_COOKIE['VOLLEYSTATSAUTH'] != md5($_SESSION['username'] . $_SERVER['REMOTE_ADDR'] . $_SESSION['authsalt']))) {

  header("Location: login-page.php");
  exit();
}
?>