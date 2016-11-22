<php?
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


}
?>



