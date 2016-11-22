<php?

class Stat
{
	
	private $stat_id;
	private $player_id;
	private $game_id;
	private $stat_type;
	private $set;
	private $player_score;
	private $opponent_score;
	private $value;



	public function __construct($sid, $pid, $gid, $type, $set, $pscore, $oscore, $value)
	{
		$this->stat_id = $sid;
		$this->player_id = $pid;
		$this->stat_type = $type;
		$this->game_id = $gid;
		$this->set = $set;
		$this->player_score = $pscore;
		$this->opponent_score = $oscore;
		$this->value = $value;

	}




}

?>