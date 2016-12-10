<?php
include_once 'DataInterface.php';
if(session_status() !== PHP_SESSION_ACTIVE ){
  session_start();
}

include_once("authenticate.php");

if($_POST){
	$data = new DataInterface();
	$game = new Game($_SESSION['current_team']->getID(), $_SESSION['current_team']->getName(),
					 $_POST["opponent_name"], intval($_POST["opponent_wins"]),
					 intval($_POST["opponent_losses"]), $_POST["location"], intval($_POST["max_sets"]));
	$team = $_SESSION['current_team'];
	$players = $team->getPlayers();
	$playerCount = 0;
	foreach($players as $player){
		$player->clearStats();
		$player->addStat(new Stat(StatType::KILL, 0));
		$player->addStat(new Stat(StatType::HIT_ATTEMPT, 0));
		$player->addStat(new Stat(StatType::HIT_ERROR, 0));
		$player->addStat(new Stat(StatType::BLOCK, 0));
		$player->addStat(new Stat(StatType::BLOCKING_ERROR, 0));
		$player->addStat(new Stat(StatType::ASSIST, 0));
		$player->addStat(new Stat(StatType::SET_ERROR, 0));
		$player->addStat(new Stat(StatType::DIG, 0));
		$player->addStat(new Stat(StatType::PASS_ERROR, 0));
		$player->addStat(new Stat(StatType::ACE, 0));
		$player->addStat(new Stat(StatType::SERVING_ERROR, 0));
		$player->addStat(new Stat(StatType::SERVING_ATTEMPT, 0));
		if(isset($_POST["start_".$player->getID()])){
			$game->addPlayerToActive($player);
			$playerCount += 1;
		}
		else{
			$game->addPlayerToInactive($player);
		}
	}
	if($playerCount === 6){
		$_SESSION["active_game"] = $game;
		unset($_POST);
  		header("Location: ".$_SERVER['REQUEST_URI']);
  		exit();
  	}
  	else{
  		unset($game);
  		unset($players);
  		header("Location: stats.php?error=invalid_start#game");
  	}
}

include_once "Nav.php";
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
<script src="VolleyConstants.js"></script>
<script src="RecordGame.js"></script>
<script src="VolleyDataObjects.js"></script>
</head>

<body>
<!-- The Modal -->
<div id="modal1" class="modal">
   	<div class="modal-content">
    	<h4 id="modal-header"></h4>
    	<h5 id="modal-team1-score"></h5>
    	<h5 id="modal-team2-score"></h5>
    	<p id="modal-info"></p>
    </div>
    <div class="modal-footer">
      	<a href="#!" id="modal-continue" class=" modal-action modal-close waves-effect waves-green btn-flat">Continue</a>
      	<a href="#!" id="modal-cancel" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
   	</div>
</div>
<div class="section blue z-depth-5">
	<div class="row white-text">
		<div class="valign-wrapper">
		<h3 id="team1_score" class="col s4 center-align"></h3>
		<div id="sets_label" class="col s4 center-align"></div>
		<h3 id="team2_score" class="col s4 center-align"></h3>
		</div>
	</div>
	<div class="row white-text">
		<div class="valign-wrapper">
		<h3 id="team1_label" class="col s4 center-align"></h3>
		<div id="team1_sets" class="col s2 center-align"></div>
		<div id="team2_sets" class="col s2 center-align"></div>
		<h3 id="team2_label" class="col s4 center-align"></h3>
		</div>
	</div>
	<div class="row white-text">
		<div class="valign-wrapper">
		<div class="col s2 right-align">
			<a class="btn-floating btn-small waves-effect waves-light grey darken-3" id="minus_team1">
				<i class="material-icons">remove</i>
			</a>
		</div>
		<div class="col s2 left-align">
			<a class="btn-floating btn-small waves-effect waves-light grey darken-3" id="add_team1">
				<i class="material-icons">add</i>
			</a>
		</div>
		<div class="col s4 center-align"></div>
		<div class="col s2 right-align">
			<a class="btn-floating btn-small waves-effect waves-light grey darken-3" id="minus_team2">
				<i class="material-icons">remove</i>
			</a>
		</div>
		<div class="col s2 left-align">
			<a class="btn-floating btn-small waves-effect waves-light grey darken-3" id="add_team2">
				<i class="material-icons">add</i>
			</a>
		</div>
		</div>
	</div>
</div>
<br>
	<div class="row">
		<div class="col s2"></div>
		<div class="col s2">
			<div class="card-panel grey activePlayer" id="activePlayer0"><p id="p1name"></p></div>
		</div>
		<div class="col s1"></div>
		<div class="col s2">
			<div class="card-panel grey activePlayer" id="activePlayer1"><p id="p2name"></p></div>
		</div>
		<div class="col s1"></div>
		<div class="col s2">
			<div class="card-panel grey activePlayer" id="activePlayer2"><p id="p3name"></p></div>
		</div>
		<div class="col s2"></div>
	</div>
	<div class="row">
		<div class="col s2"></div>
		<div class="col s2">
			<div class="card-panel grey activePlayer" id="activePlayer3"><p id="p4name"></p></div>
		</div>
		<div class="col s1"></div>
		<div class="col s2">
			<div class="card-panel grey activePlayer" id="activePlayer4"><p id="p5name"></p></div>
		</div>
		<div class="col s1"></div>
		<div class="col s2">
			<div class="card-panel grey activePlayer" id="activePlayer5"><p id="p6name"></p></div>
		</div>
		<div class="col s2"></div>
	</div>
	<div class="row">
		<div class="col s2 center-align">
		<a class='dropdown-button btn-floating btn-large center-align amber' data-activates='dropdown1'>Hit</a>
			<ul id='dropdown1' class='dropdown-content' hover='true'>
    			<li id="Stat1" class="stat-button"><a href="#!">Kill</a></li>
    			<li id="Stat2" class="stat-button"><a href="#!">Attempt</a></li>
    			<li id="Stat3" class="stat-button"><a href="#!">Error</a></li>
 		 	</ul>
 		 </div>
 		 <div class="col s2 center-align">
 		 	<a class='dropdown-button btn-floating btn-large center-align amber' data-activates='dropdown2'>Pass</a>
				 <ul id='dropdown2' class='dropdown-content'>
    				<li id="Stat8" class="stat-button"><a href="#!">Dig</a></li>
    				<li id="Stat9" class="stat-button"><a href="#!">Error</a></li>
 		 		</ul>
 		 </div>
 		 <div class="col s2 center-align">
 		 	<a class='dropdown-button btn-floating btn-large center-align amber' data-activates='dropdown3'>Set</a>
				 <ul id='dropdown3' class='dropdown-content'>
    				<li id="Stat6" class="stat-button"><a href="#!">Assist</a></li>
    				<li id="Stat7" class="stat-button"><a href="#!">Error</a></li>
 		 		</ul>
 		 </div>
 		 <div class="col s2 center-align">
 		 	<a class='dropdown-button btn-floating btn-large center-align amber' data-activates='dropdown4'>Serve</a>
				 <ul id='dropdown4' class='dropdown-content'>
    				<li id="Stat10" class="stat-button"><a href="#!">Ace</a></li>
    				<li id="Stat11" class="stat-button"><a href="#!">Error</a></li>
 		 		</ul>
 		 </div>
 		 <div class="col s2 center-align">
 		 	<a class='dropdown-button btn-floating btn-large center-align amber' data-activates='dropdown5'>Block</a>
				 <ul id='dropdown5' class='dropdown-content'>
    				<li id="Stat4" class="stat-button"><a href="#!">Full Block</a></li>
    				<li id="Stat4" class="stat-button"><a href="#!">Half Block</a></li>
    				<li id="Stat5" class="stat-button"><a href="#!">Error</a></li>
 		 		</ul>
 		 </div>
 		 <div class="col s2 center-align">
 		 	<a class='dropdown-button btn-floating btn-large center-align brown' data-activates='subDropdown'>
 		 		<i class="material-icons">swap_vert</i>
 		 	</a>
				 <ul id='subDropdown' class='dropdown-content'>
 		 		</ul>
 		 </div>
	</div>
<table id="stat_table" class="bordered centered blue white-text">
	<thead>
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
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</body>