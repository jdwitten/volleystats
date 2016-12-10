<?php

include_once 'DataInterface.php';
include_once 'VolleyConstants.php';
include_once 'Team.php';
include_once 'Player.php';
include_once 'User.php';
include_once 'Stat.php';
if(session_status() !== PHP_SESSION_ACTIVE ){
  session_start();
}
include_once("authenticate.php");
if(!isset($_SESSION['current_user'])){
	header("index.html");
	exit();
}

$data_access = new DataInterface();

$cur_user = $_SESSION['current_user'];

if(!isset($_SESSION["current_team"])){
  $teams = $data_access->getTeamIds($_SESSION["current_user"]->getUserId());
  if(count($teams)>0){
    $_SESSION["current_team"] = $data_access->getTeam(intval($teams[0]));
  }
  else{
    $_SESSION["current_team"] = $data_access->createTeam("Make a Team!", "Edit Me!", 1, $_SESSION["current_user"]->getUserId());
    $_SESSION["current_team"]->addPlayer($data_access->createPlayer("Example", "Player",1,1,$_SESSION["current_team"]->getID()));
  }
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
<script src="VolleyDataObjects.js"></script>
<script src="TeamManagement.js"></script>
<script src="VolleyConstants.js"></script>
</head>
<body>';

require_once "Nav.php";
echo "<!-- The Modal -->
<div id='modal1' class='modal'>
   	<div class='modal-content'>
    	<h4 id='modal-header'>Filter</h4>
    	<div class='row'>
    		<div class='input-field col s6'>
    			<select id='game-options'>
    			</select>
    			<label>Games</label>
    		</div>
    		<div class='input-field col s6'>
          <select id='set_num'>
            <option value='All'>All</option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
          </select>
          <label>Sets</label>
          </div>
        </div>
        <div class='row'>
          <div class='input-field col s6'>
              <input id='your_min_score' type='number' class='validate'>
              <label for='your_min_score'>Your Min Score</label>
          </div>
        	<div class='input-field col s6'>
          		<input id='your_max_score' type='number' class='validate'>
          		<label for='your_max_score'>Your Max Score</label>
        	</div>
        </div>
        <div class='row'>
          <div class='input-field col s6'>
              <input id='opp_min_score' type='number' class='validate'>
              <label for='opp_min_score'>Opponent Min Score</label>
          </div>
        	<div class='input-field col s6'>
          		<input id='opp_max_score' type='number' class='validate'>
          		<label for='opp_max_score'>Opponent Max Score</label>
        	</div>
        </div>
        <div class='row'>
          <div class='input-field col s6'>
              <input id='min_score_diff' type='number' class='validate'>
              <label for='min_score_diff'>Min Score Difference</label>
          </div>
          <div class='input-field col s6'>
              <input id='max_score_diff' type='number' class='validate'>
              <label for='max_score_diff'>Max Score Difference</label>
          </div>
        </div>
  	</div>
    <div class='modal-footer'>
      	<a href='#!'' id='modal-filter' class='modal-action modal-close waves-effect waves-green btn-flat'>Filter</a>
      	<a href='#!' id='modal-cancel' class='modal-action modal-close waves-effect waves-red btn-flat'>Cancel</a>
   	</div>
</div>";
echo "<div id='modal-overlay'></div>";
echo '<div class="section">
		  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s3"><a class="blue-text active" href="#stats">Team Statistics</a></li>
        <li class="tab col s3"><a class="blue-text" href="#edit">Edit Roster</a></li>
        <li class="tab col s3"><a class="blue-text" href="#game">Start Game</a></li>
        <li class="tab col s3"><a class="blue-text" href="#team" id="team-tab">Manage Teams</a></li>
      </ul>
    </div>
  </div>';

echo "<div id='stats'>";
echo "<div class='row valign-wrapper'>";
echo "<h2 id='team_name' class='col s6 valign'></h2>";
echo "<div class='col s6 right-align valign'>";
echo "<a class='btn-floating btn-large center-align amber' id='filter-open'><i class='material-icons'>search</i></a>";
echo "</div></div>";
echo '<table id="stat_table" class="bordered centered blue white-text">


	<thead>
    <tr class="blue lighten-3 black-text">
      <th class="sort-header" id="type_0">Name</th>
      <th class="sort-header" id="type_0">Number</th>
      <th class="sort-header" id="type_0">Position</th>
      <th class="sort-header" id="type_1">Kills</th>
      <th class="sort-header" id="type_2">Hitting Attempts</th>
      <th class="sort-header" id="type_3">Hitting Errors</th>
      <th class="sort-header" id="type_4">Blocks</th>
	  <th class="sort-header" id="type_5">Blocking Errors</th>
	  <th class="sort-header" id="type_6">Assists</th>
	  <th class="sort-header" id="type_7">Setting Errors</th>
	  <th class="sort-header" id="type_8">Digs</th>
	  <th class="sort-header" id="type_9">Passing Errors</th>
	  <th class="sort-header" id="type_10">Aces</th>
	  <th class="sort-header" id="type_11">Serving Errors</th>
	  <th class="sort-header" id="type_12">Serving Attempts</th>
    </tr>
    </thead>
    <tbody>
    </tbody>';
echo "</table>";
echo "</div>";

echo "<div id='edit'>";
echo "<div class='container'>";
echo "<h3 id='team_name_edit'></h3>";
echo " <ul class='collapsible' data-collapsible='accordion' id='player-collection'>;
      </ul>";
echo "</div>";
echo "</div>";

echo "<div id='team'>";
echo "<div class='container'>";
echo "<h3 id='user_name_edit'></h3>";
echo " <ul class='collapsible' data-collapsible='accordion' id='team-collection'>;
      </ul>";
echo "</div>";
echo "</div>";

echo "<div id='game' class='section'>";
echo "<div class='container'>";
echo "<h3>Start a Game</h3>";
echo "<form class='col s12' action='RecordGame.php' method='post'>";
echo "<div class='row'>";
echo "<div class='input-field col s6'>
          <input name='opponent_name' type=text class='validate'>
          <label for='opponent_name'>Opponent Name</label>
        </div>";
echo "<div class='input-field col s3'>
          <input name='opponent_wins' type=number class='validate'>
          <label for='opponent_wins'>Opponent Wins</label>
        </div>";
echo "<div class='input-field col s3'>
          <input name='opponent_losses' type=number class='validate'>
          <label for='opponent_losses'>Opponent Losses</label>
        </div>";
echo "</div><div class='row'>";
echo "<div class='input-field col s3'>
    	<select name='location'>
      		<option value='' disabled selected>Select</option>
      		<option value='home'>Home</option>
      		<option value='away'>Away</option>
    	</select>
    <label>Location</label>
  	</div>";
echo "<div class='input-field col s3'>
		<input name='date' type='date' class='datepicker'>
		<label for='date'>Date</label>
	</div>";
echo "<div class='input-field col s3'>
    	<select name='max_sets'>
      		<option value='' disabled selected>Select</option>
      		<option value='1'>1</option>
      		<option value='3'>3</option>
      		<option value='5'>5</option>

    	</select>
    <label>Best Of</label>
  	</div>";
echo "</div>";
echo "<h3>Starting Lineup</h3>";
echo "<div class='row' id='starting_options'></div>";
echo "<button class='btn waves-effect waves-light' type='submit' name='action'>Start
   			 <i class='material-icons right'>send</i>
  		</button>";
echo "</form>";
if(isset($_GET["error"]) && $_GET["error"]=="invalid_start"){
  echo "<h5>You must start 6 Players</h5>";
  unset($_GET);
}
echo "</div>";
echo "</div>";



echo '</body></html>';

?>