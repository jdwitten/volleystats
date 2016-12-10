<?php

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

	}

	public function addPlayer($player)
	{
		if(isset($player))
		{
			$this->players[] = $player;
			return true;
		}
		else return false;
	}

	public function getPlayers(){return $this->players;}
	public function getName(){return $this->name;}
	public function getID(){return $this->team_id;}
	public function clearPlayers(){$this->players = array();}

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