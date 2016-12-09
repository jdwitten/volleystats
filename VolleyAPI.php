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

		if($_GET["gameID"]==="All"){$gameID=null;}
		else{$gameID = $_GET["gameID"];}

		if($_GET["setNum"]==="All"){$setNum=null;}
		else{$setNum = $_GET["setNum"];}

		$yourMinScore = $_GET["yourMinScore"];
		$yourMaxScore = $_GET["yourMaxScore"];
		$opponentMinScore = $_GET["opponentMinScore"];
		$opponentMaxScore = $_GET["opponentMaxScore"];
		$minScoreDifference = $_GET["minScoreDifference"];
		$maxScoreDifference = $_GET["maxScoreDifference"];
		foreach($_SESSION["current_team"]->getPlayers() as $player){
			$player->clearStats();
			$player->addStat($data_access->getStat(StatType::KILL,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::HIT_ATTEMPT,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::HIT_ERROR,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::BLOCK,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::BLOCKING_ERROR,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::ASSIST,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::SET_ERROR,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::DIG,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::PASS_ERROR,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::ACE,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::SERVING_ERROR,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
			$player->addStat($data_access->getStat(StatType::SERVING_ATTEMPT,$player->getId(), $gameID,
							 $setNum, $yourMinScore, $yourMaxScore, $opponentMinScore, $opponentMaxScore,
							 $minScoreDifference, $maxScoreDifference));
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
	else if($_POST["action"] ==="update_player"){
		$response["success"] = true;
	}
}
header('Content-type: application/json');
echo json_encode($response);
?>