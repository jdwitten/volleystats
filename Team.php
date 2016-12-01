<?php
include_once "DataInterface.php";
session_start();
class Team
{
	private $name;
	private $user_id;
	private $players;
	private $location;
	private $skill_level;
	private $team_id;

	public function __construct($uid, $name, $loc, $skill, $id)
	{
		$this->user_id = $uid;
		$this->location = $loc;
		$this->skill_level = $skill;
		$this->players = array();
		$this->name = $name;
		$this->team_id = $id;

		$player1 = new Player(1, "Jonathan", "Witten", "OH", 14, 1);
		$player2 = new Player(2, "Joe", "Black", "L", 2, 1);
		$player3 = new Player(1, "TJ", "Andrews", "S", 6, 1);

		array_push($this->players, $player1, $player2, $player3);

	}

	public function addPlayer($player)
	{
		if(isset($player))
		{
			$this->players = $player;
			return true;
		}
		else return false;
	}

	public function getPlayers(){return $this->players;}
	public function getName(){return $this->name;}

	public function convertToArray(){
		$team = Array();
		$team["user"] = $this->user_id;
		$team["location"] = $this->location;
		$team["skill"] = $this->skill_level;
		$players = Array();
		foreach($this->players as $player){
			$players[] = $player->convertToArray();
		}
		$team["players"] = $players;
		$team["name"] = $this->name;
		$team["id"] = $this->team_id;
		return $team;
	}

}

if($_GET)
{
	$data_access = new DataInterface();
	if(!isset($_SESSION['current_team']))
	{
		$response = array("success"=>false);
	}
	else if($_GET["action"] == "get_current"){
		$response = array("success"=>true);
		$response["team"] = $_SESSION['current_team']->convertToArray();
	}
	else if($_GET["action"] == "calculate_stats"){
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
	}else{}
	header('Content-type: application/json');
    echo json_encode($response);
}



?>



