<php?
include(User.php)
include(Team.php)
include(Player.php)

class DataInterface
{
	public function createUser($fname, $lname, $uname, $pass, $uid, $email)
	{
		//Do stuff here to check validation of User info

		//Try to insert new user into the database

		//Create and return a new user object
	}

	public function getExistingUser($uid)
	{
		//Fetch User from the database
		//Create and return a User object
	}

	public function createTeam($uid, $team, $location, $skill)
	{
		//Try to create a new team in the database
		//Return a new Team object
	}

	public function createPlayer($pid, $fname, $lname, $position1, $position2, $number, $team)

	public function getExistingTeam($team)
	{
		//Get Team from the database
		//Return a Team object
	}

	public function updatePlayer($player)
	{
		//update the fields of a player object
	}

	public function updateTeam($team)
	{
		//update the fields of a team object
	}







}
?>