<?php

class Player
{
	private $player_id;
	private $first_name;
	private $last_name;
	private $position;
	private $number;
	private $team_id;
	private $stats;

	public function __construct($pid, $fname, $lname, $position, $number, $team)
	{
		$this->player_id = $pid;
		$this->first_name = $fname;
		$this->last_name = $lname;
		$this->position = $position;
		$this->team_id = $team;
		$this->number = $number;
		$this->stats = Array();
	}

	public function clearStats()
	{
		unset($this->stats);
	}

	public function addStat($stat)
	{
		$this->stats = $stat;
	}
	public function getId(){return $this->player_id;}
	public function getFirstName(){return $this->first_name;}
	public function getLastName(){return $this->last_name;}
	public function getPosition(){return $this->position;}
	public function getNumber(){return $this->number;}
	public function getTeamId(){return $this->team_id;}

	public function convertToArray()
	{
		$player = Array();
		$player["id"] = $this->player_id;
		$player["first_name"] = $this->first_name;
		$player["last_name"] = $this->last_name;
		$player["position"] = $this->position;
		$player["number"] = $this->number;
		$player["team_id"] = $this->team_id;
		$array_stats = Array();
		foreach($this->stats as $stat){
			$array_stats[] = $stat->convertToArray();
		}
		$player["stats"] = $array_stats;
		return $player;
	}


}

?>