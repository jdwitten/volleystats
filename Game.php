<?php
include(DataInterface.php);

class Game
{
	private $team1;
	private $team2;
	private $location;
	private $team1_scores;
	private $team2_scores;
	private $game_id;
	private $season_id;

	public function __construct($team1, $team2, $location, $gid, $sid)
	{
		$this->team1 = getTeam($team1);
		$this->team2 = getTeam($team2);
		$this->location = $location;
		$this->game_id = $gid;
		$this->season_id = $sid;


	}



}
?>
