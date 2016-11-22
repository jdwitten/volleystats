<php?

class Player
{
	private $player_id;
	private $first_name;
	private $last_name;
	private $primary_position;
	private $secondary_position;
	private $number;
	private $team_id;
	private $stats;

	public function __construct($pid, $fname, $lname, $position1, $position2, $number, $team)
	{
		$this->player_id = $pid;
		$this->first_name = $fname;
		$this->last_name = $lname;
		$this->primary_position = $position1;
		$this->secondary_position = $position2;
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
		$this->stats[] = $stat;
	}




}













?>