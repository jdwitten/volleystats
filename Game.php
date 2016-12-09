<?php
include_once('DataInterface.php');

class Game
{
	private $gameID;
	private $team1ID;
	private $team1Name;
	private $team2Name;
	private $location;
	private $opponentWins;
	private $opponentLosses;
	private $maxSets;
	private $currentSet;
	private $mySetsWon;
	private $opponentSetsWon;
	private $myCurrentScore;
	private $opponentCurrentScore;
	private $activePlayers;
	private $inactivePlayers;
	private $stats;
	private $team1scores;
	private $team2scores;

	public function __construct($team1ID, $team1Name, $team2Name, $opponentWins, $opponentLosses, $location, $maxSets)
	{
		$this->gameID = 0;
		$this->team1ID = $team1ID;
		$this->team1Name = $team1Name;
		$this->team2Name = $team2Name;
		$this->location = $location;
		$this->opponentWins = $opponentWins;
		$this->opponentLosses = $opponentLosses;
		$this->maxSets = $maxSets;
		$this->currentSet = 1;
		$this->mySetsWon = 0;
		$this->opponentSetsWon = 0;
		$this->myCurrentScore = 0;
		$this->opponentCurrentScore = 0;
		$this->activePlayers = Array();
		$this->inactivePlayers = Array();
		$this->stats = Array();
		$this->team1scores = Array(null, null, null, null, null);
		$this->team2scores = Array(null, null, null, null, null);
	}

	public function addPlayerToActive($player)
	{
		$this->activePlayers[] = $player;
	}
	public function addPlayerToInactive($player)
	{
		$this->inactivePlayers[] = $player;
	}

	public function subPlayers($activeID, $inactiveID)
	{
		$i=0;
		foreach($this->activePlayers as $player){
			if($player->getID()===$activeID){
				$activeIndex = $i;
				break;
			}
			else{ $i = $i+1;}
		}
		$j=0;
		foreach($this->inactivePlayers as $player){
			if($player->getID()===$inactiveID){
				$inactiveIndex = $j;
				break;
			}
			else{ $j = $j+1;}
		}

		$activePlayer = $this->activePlayers[$activeIndex];
		$this->activePlayers[$activeIndex] = $this->inactivePlayers[$inactiveIndex];
		$this->inactivePlayers[$inactiveIndex] = $activePlayer;
		return true;

	}

	public function addStat($playerID, $statCode, $value, $playerScore, $opposingScore, $setNum)
	{
		$stat["playerID"] = $playerID;
		$stat["statCode"] = $statCode;
		$stat["value"] = $value;
		$stat["playerScore"] = $playerScore;
		$stat["opposingScore"] = $opposingScore;
		$stat["setNum"] = $setNum;
		$this->stats[] = $stat;

		foreach($this->activePlayers as $player){
			if($player->getID() === $playerID){
				$player->incrementStat($statCode, $value);
			}
		}
	}

	public function convertToArray(){
		$array["gameID"] = $this->gameID;
		$array["team1ID"] = $this->team1ID;
		$array["team1Name"] = $this->team1Name;
		$array["team2Name"] = $this->team2Name;
		$array["location"] = $this->location;
		$array["opponentWins"] = $this->opponentWins;
		$array["opponentLosses"]  = $this->opponentLosses;
		$array["maxSets"] = $this->maxSets;
		$array["currentSet"] = $this->currentSet;
		$array["mySetsWon"] = $this->mySetsWon;
		$array["opponentSetsWon"] = $this->opponentSetsWon;
		$array["myCurrentScore"] = $this->myCurrentScore;
		$array["opponentCurrentScore"] = $this->opponentCurrentScore;
		$array["activePlayers"] = Array();
		foreach($this->activePlayers as $player){
			$array["activePlayers"][] = $player->convertToArray();
		}
		$array["inactivePlayers"] = Array();
		foreach($this->inactivePlayers as $player){
			$array["inactivePlayers"][] = $player->convertToArray();
		}
		return $array;
	}
	public function setMyCurrentScore($score){$this->myCurrentScore = $score;}
	public function setOpponentCurrentScore($score){$this->opponentCurrentScore = $score;}
	public function setOpponentSetsWon($score){$this->opponentSetsWon = $score;}
	public function setMySetsWon($score){$this->mySetsWon = $score;}
	public function setCurrentSet($set){$this->currentSet = $set;}
	public function setID($id){$this->gameID = $id;}
	public function getTeam1Scores(){return $this->team1scores;}
	public function getTeam2Scores(){return $this->team2scores;}
	public function getTeam1ID(){return $this->team1ID;}
	public function getTeam2Name(){return $this->team2Name;}
	public function getTeam1Name(){return $this->team1Name;}

	public function compileStats()
	{
		$playerArr = Array();
		foreach($this->activePlayers as $player){
			$playerArr[] = $player->convertToArray();
		}
		foreach($this->inactivePlayers as $player){
			$playerArr[] = $player->convertToArray();
		}
		return $playerArr;
	}

	public function update($myCurrentScore, $opponentCurrentScore, $mySetsWon, $opponentSetsWon, $currentSet)
	{
		if($currentSet !== $this->currentSet){
			$team1scores[$this->currentSet] = $this->myCurrentScore;
			$team1scores[$this->currentSet] = $this->myCurrentScore;
		}
		$this->myCurrentScore = $myCurrentScore;
		$this->opponentCurrentScore = $opponentCurrentScore;
		$this->mySetsWon = $mySetsWon;
		$this->opponentSetsWon = $opponentSetsWon;
		$this->currentSet = $currentSet;
	}




}
?>
