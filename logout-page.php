<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['authsalt']);
unset($_SESSION["current_user"]);
unset($_SESSION["current_team"]);

header("Location: index.html");
exit();
?>