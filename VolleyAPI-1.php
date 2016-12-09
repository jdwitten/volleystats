<?php
include_once "DataInterface.php";
if(session_status() !== PHP_SESSION_ACTIVE ){
  session_start();
}
include_once("authenticate.php");

if($_GET && $_GET['action'])
{
	$data_access = new DataInterface();

	//Get the current team without calculating any new stats
	if($_GET["action"] == "current_team"){
		if(!isset($_SESSION['current_team'])){$response = array("success"=>false);}
		$response = array("success"=>true);
		$response["team"] = $_SESSION['current_team']->convertToArray();
	}

	//Calculate the specified stats for the current team
	else if($_GET["action"] == "current_team_stats"){
		foreach($_SESSION["current_team"]->getPlayers() as $player){
			$player->clearStats();
			$player->addStat($data_access->getStat($player->getId(),StatType::KILL));
			$player->addStat($data_access->getStat($player->getId(),StatType::HIT_ATTEMPT));
			$player->addStat($data_access->getStat($player->getId(),StatType::HIT_ERROR));
			$player->addStat($data_access->getStat($player->getId(),StatType::BLOCK));
			$player->addStat($data_access->getStat($player->getId(),StatType::BLOCKING_ERROR));
			$player->addStat($data_access->getStat($player->getId(),StatType::ASSIST));
			$player->addStat($data_access->getStat($player->getId(),StatType::SET_ERROR));
			$player->addStat($data_access->getStat($player->getId(),StatType::DIG));
			$player->addStat($data_access->getStat($player->getId(),StatType::PASS_ERROR));
			$player->addStat($data_access->getStat($player->getId(),StatType::ACE));
			$player->addStat($data_access->getStat($player->getId(),StatType::SERVING_ERROR));
			$player->addStat($data_access->getStat($player->getId(),StatType::SERVING_ATTEMPT));
		}
		$response = array("success"=>true);
		$response["team"] = $_SESSION["current_team"]->convertToArray();
	}

	//Get the active players for the current game
	else if($_GET["action"] === "active_players"){
		if(!isset($_SESSION["active_game"]))$response["success"] = false;
		else{
			$arr = $_SESSION["active_game"]->convertToArray();
			$response["active_players"] = $arr["activePlayers"];
		}
	}
	else if($_GET["action"] === "inactive_players"){
		if(!isset($_SESSION["active_game"]))$response["success"] = false;
		else{
			$arr = $_SESSION["active_game"]->convertToArray();
			$response["inactive_players"] = $arr["inactivePlayers"];
		}
	}

	else if($_GET["action"] === "active_game"){
		$response["active_game"] = $_SESSION["active_game"]->convertToArray();
	}
	else if($_GET["action"] === "game_stats"){
		$game = $_SESSION["active_game"];
		$response["players"] = $game->compileStats();
	}
	else if($_GET["action"] === "game_info")
	{
		$game_ids = $data_access->getGameIds(intval($_GET["teamId"]));
		$games = Array();
		foreach($game_ids as $gid){
			$gameObject = $data_access->getGame($gid);
			$games[] = $gameObject->convertToArray();
		}
		$response["games"] = $games;
	}
	header('Content-type: application/json');
    echo json_encode($response);
}
if($_POST && $_POST["action"])
{
	if($_POST["action"]==="add_stat")
	{
		$_SESSION["active_game"]->addStat(intval($_POST["player"]),intval($_POST["stat"]), 
										  intval($_POST["value"]), intval($_POST["pScore"]),
										  intval($_POST["oScore"]),intval($_POST["set"])); 
	}
	else if($_POST["action"] === "update_team")
	{
		$_SESSION["active_game"]->setMyCurrentScore(intval($_POST["myCurrentScore"]));
		$_SESSION["active_game"]->setOpponentCurrentScore(intval($_POST["opponentCurrentScore"]));
		$_SESSION["active_game"]->setMySetsWon(intval($_POST["mySetsWon"]));
		$_SESSION["active_game"]->setOpponentSetsWon(intval($_POST["opponentSetsWon"]));
		$_SESSION["active_game"]->setCurrentSet(intval($_POST["currentSet"]));
	}
	else if($_POST["action"] === "sub_player"){
		$_SESSION["active_game"]->subPlayers(intval($_POST["activeID"]), intval($_POST["inactiveID"]));	
	}
	else if($_POST["action"] == "update_game"){
		$_SESSION["active_game"]->update(intval($_POST["myCurrentScore"]), 
										intval($_POST["opponentCurrentScore"]),
										intval($_POST["mySetsWon"]),intval($_POST["opponentSetsWon"]),
										intval($_POST["currentSet"]));
	}
	else if($_POST["action"]== "save_game"){
		$team1scores = $_SESSION["active_game"]->getTeam1Scores();
		$team2scores = $_SESSION["active_game"]->getTeam2Scores();

		$data_access->createGame($_SESSION["active_game"]->getTeam1ID, $_SESSION["active_game"]->getTeam2Name(), $_SESSION["active_game"]->getCurrentSet(), $team1scores[0],$team1scores[1],$team1scores[2],$team1scores[3],$team1scores[4],$team1scores[5],$team2scores[0],$team2scores[1], $team2scores[2],$team2scores[3],$team2scores[4],$team1scores[5], 1);
	}
	else if($_POST["action"]== "create_player") {
		$data_access->createPlayer($_POST["fname"], $_POST["lname"], intval($_POST["position"]), intval($_POST["number"]), $_POST["teamId"]);
	}
	else if($_POST["action"]== "update_player") {
		$data_access->updatePlayer(intval($_POST["pid"]), $_POST["fname"], $_POST["lname"], intval($_POST["position"]), intval($_POST["number"]), intval($_POST["teamId"]));
	}
	else if($_POST["action"]== "update_team") {
		$data_access->updateTeam(intval($_POST["teamId"]), $_POST["teamName"], intval($_POST["uid"]), $_POST["location"], intval($_POST["skill"]));
	}
	else if($_POST["action"]== "create_team") {
		$data_access->createTeam($_POST["teamName"], $_POST["location"], intval($_POST["skill"]), intval($_POST["uid"]));
	}
}
?>