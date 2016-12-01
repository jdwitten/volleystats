<?php
include_once 'DataInterface.php';
include_once 'VolleyConstants.php';
include_once 'Team.php';
include_once 'Player.php';
include_once 'User.php';
include_once 'Stat.php';

session_start();
if(!isset($_SESSION['current_user'])){
	header("index.html");
	exit();
}

$data_access = new DataInterface();

$cur_user = $_SESSION['current_user'];
$_SESSION["current_team"] = $data_access->getTeam(1);
$team_ids = $data_access->getTeamIds($cur_user->getUserId());
foreach($team_ids as $id){
	$teams[] = $data_access->getTeam($id);
}
if(isset($teams)){
	$_SESSION['teams'] = $teams;
	$current_team = $teams[count($teams)-1];
}


echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<title>VolleyStats</title>

  <!-- CSS  -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="css/materialize.css" type="text/css" rel="stylesheet"/>
<link href="style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="TeamManagement.js"></script>
<script src="VolleyConstants.js"></script>
</head>
<body>';

require_once "Nav.php";
echo '<div class="section">
		  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s4"><a class="blue-text active" href="#stats">Team Statistics</a></li>
        <li class="tab col s4"><a class="blue-text" href="#roster">Edit Roster</a></li>
        <li class="tab col s4"><a class="blue-text" href="#game">Start Game</a></li>
      </ul>
    </div>
  </div>';

echo "<div id='stats'>";
	/*
		<div class='row'>
			<div class='col s1'></div>
			<a class='dropdown-button btn grey white-text col s3' style='border-color:blue' href='#' data-activates='dropdown1'>".$current_team->getName()."</a>
			<ul id='dropdown1' class='dropdown-content'>";
		foreach($_SESSION['teams'] as $team){
			echo "<li>". $team->getName()."</li>";
		}
echo "</ul><div class='col s1'></div>";		

echo "<a class='dropdown-button btn grey white-text col s2' style='border-color:blue' href='#' data-activates='dropdown1'><i class='material-icons left'>import_export</i></a>
	<ul id='dropdown2' class='dropdown-content'>";

		foreach($_SESSION['teams'] as $team){
			echo "<li>". $team->getName()."</li>";
		}	
echo "</ul><div class='col s1'></div>";
echo "<a class='dropdown-button btn grey white-text col s2' style='border-color:blue' href='#' data-activates='dropdown1'><i class='material-icons left'>shuffle</i></a>
			<ul id='dropdown2' class='dropdown-content'>";

		foreach($_SESSION['teams'] as $team){
			echo "<li>". $team->getName()."</li>";
		}


echo '</ul></div>';

echo '<table class="bordered centered blue white-text">

    <tr class="blue lighten-3 black-text">
      <th>Name</th>
      <th>Number</th>
      <th>Position</th>
      <th>Kills</th>
      <th>Hitting Attempts</th>
      <th>Hitting Errors</th>
      <th>Blocks</th>
	  <th>Blocking Errors</th>
	  <th>Assists</th>
	  <th>Setting Errors</th>
	  <th>Digs</th>
	  <th>Passing Errors</th>
	  <th>Aces</th>
	  <th>Serving Errors</th>
	  <th>Serving Attempts</th>
    </tr>';

foreach($current_team->getPlayers() as $player){
	echo '<tr>
	<td>'.$player->getFirstName()." ".$player->getLastName().'</td>
	<td>'.$player->getNumber().'</td>
	<td>'.$player->getPosition().'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::KILL).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::HIT_ATTEMPT).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::HIT_ERROR).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::BLOCK).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::BLOCKING_ERROR).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::ASSIST).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::SET_ERROR).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::DIG).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::PASS_ERROR).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::ACE).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::SERVING_ERROR).'</td>
	<td>'.$data_access->getStat($player->getId(),StatType::SERVING_ATTEMPT).'</td>
	</tr>';

}
echo "</table><";
*/
echo "</div>";
echo '</body></html>';

?>