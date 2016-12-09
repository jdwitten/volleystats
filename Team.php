<?php
include_once "DataInterface.php";

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
		$player3 = new Player(3, "TJ", "Andrews", "S", 6, 1);
		$player4 = new Player(4, "Grace", "Busby", "RS", 9, 1);
		$player5 = new Player(5, "Andrew", "Brown", "MB", 12, 1);
		$player6 = new Player(6, "Hunter", "Bell", "MB", 15, 1);
		$player7 = new Player(7,"Caleb", "Waters","OH", 3, 1);
		$player8 = new Player(8,"Tim", "Creedon","S", 11, 1);
		$player9 = new Player(9,"Woody", "Parrish","RS", 14, 1);
		$player10 = new Player(10,"Nick", "Corbett","MB", 6, 1);

		array_push($this->players, $player1, $player2, $player3, $player4, $player5, $player6, $player7, $player8, $player9, $player10);

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
	public function getID(){return $this->team_id;}

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
?>