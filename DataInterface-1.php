<?php
include_once 'User.php';
include_once 'Team.php';
include_once 'Player.php';
include_once 'Stat.php';
include_once 'VolleyConstants.php';
class DataInterface
{
	private $conn;

	public function __construct()
	{
		$servername = "classroom.cs.unc.edu";
		$username = "tjamesa";
		$password = "Dunkindonuts#22";
		$db = "tjamesadb";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $db);
		$this->conn = $conn;
		// Check connection
		if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
		} 
	}
	public function createUser($fname, $lname, $uname, $pass, $email)
	{
		//Do stuff here to check validation of User info
		//Try to insert new user into the database
		$conn = $this->conn;
		$query_result = $conn->query("SELECT userName FROM User WHERE userName='".$uname"'");
		var_dump($query_result);
		if($query_result === false) {
			$hashpass = md5($uname."-salt".$pass);
			$sql = "INSERT INTO User (firstName, lastName, email, userName, password) VALUES ('".$fname."','".$lname."','".$email."','".$uname."','".$pass."')";
			var_dump($sql);
			$result = $conn->query($sql);
			var_dump($result);
			die();
		  if ($result) {
		  	$uid = $conn->insert_id;
			}
		}
		else {
			return null;
		}
		//Create and return a new user object
		return new User($fname, $lname, $uname, $pass, $email, $uid);
	}

	/*public function login($uname, $pass) {

		return new getUser($fname, $lname, $uname, $pass, $email, $user->getObjectId());
	}*/

	public function createGame($team1, $team2, $setsPlayed, $team1Set1Score, $team1Set2Score, $team1Set3Score, $team1Set4Score, $team1Set5Score, $team2Set1Score, $team2Set2Score, $team2Set3Score, $team2Set4Score, $team2Set5Score, $winningTeam)
	{
		$sql = "INSERT INTO Team (team1, team2, setsPlayed, team1set1score, team1set2score, team1set3score, team1set4score, team1set5score, team2set1score, team2set2score, team2set3score, team2set4score, team2set5score, winningTeam) VALUES ('".$team1."',' ".$team2."','".$setsPlayed."','".$team1Set1Score."',' ".$team1Set2Score."',' ".$team1Set3Score."',' ".$team1Set4Score."',' ".$team1Set5Score."',' ".$team2Set1Score."',' ".$team2Set2Score."',' ".$team2Set3Score."',' ".$team2Set4Score."',' ".$team2Set5Score."',' ".$winningTeam.")";
		  if ($this->conn->query($sql)) {
		  	$gameId = $this->conn->insert_id;
		  }
		return true;
	}

	public function createStat($pid, $gameId, $statType, $setNum, $playerScore, $opponentScore, $value)
	{
		$sql = "INSERT INTO Team (pid, gameId, statType, setNum, playerScore, opponentScore, value) VALUES ('".$pid."',' ".$gameId."','".$statType."','".$setNum."',' ".$playerScore."',' ".$opponentScore."',' ".$value."'')";
		  if ($this->conn->query($sql)) {
		  	$statId = $this->conn->insert_id;
		  }
		  return new Stat($statType, $value);
	}

	public function createTeam($name, $location, $skill, $uid)
	{
		//Try to create a new team in the database
		$sql = "INSERT INTO Team (uid, teamName, location, skill) VALUES ('".$uid."',' ".$name."','".$location."','".$skill."')";
		  if ($this->conn->query($sql)) {
		  	$teamId = $this->conn->insert_id;
		  }
		//Return a new Team object
		return new Team($uid, $name, $location, $skill, $teamId);
	}

	public function createPlayer($fname, $lname, $position, $number, $teamId)
	{
		$sql = "INSERT INTO Player (firstName, lastName, position, number, teamId) VALUES ('".$fname."','".$lname."','".$position."','".$number."','".$teamId."')";
		  if ($this->conn->query($sql)) {
		  	$playerId = $this->conn->insert_id;
			}
		return new Player($playerId, $fname, $lname, $position, $number, $teamId);
	}

	public function getUser($uid)
	{
		$result = $this->conn->query("SELECT firstName,lastName,email,userName,password FROM User WHERE uid='".$uid."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $fname = $row["firstName"];
		        $lname = $row["lastName"]; 
		        $email = $row["email"];
		        $username = $row["userName"];
		        $password = $row["password"];
		    }
		}
		return new User($fname, $lname, $uname, $pass, $email, $uid);
	}

	public function updatePlayer($pid, $fname, $lname, $position, $number, $teamId)
	{
		//update the fields of a player object
		if(isset($fname)); {
			$this->conn->query("UPDATE Player SET firstName='".$fname."' WHERE pid='".$pid."'");
		}
		if(isset($lname)); {
			$this->conn->query("UPDATE Player SET lastName='".$lame."' WHERE pid='".$pid."'");
		}
		if(isset($position)); {
			$this->conn->query("UPDATE Player SET position='".$position."' WHERE pid='".$pid."'");
		}
		if(isset($number)); {
			$this->conn->query("UPDATE Player SET number='".$number."' WHERE pid='".$pid."'");
		}
		if(isset($teamId)); {
			$this->conn->query("UPDATE Player SET teamId='".$teamId."' WHERE pid=".$pid."'");
		}
		//get up to date values for the player object
		$result = $this->conn->query("SELECT firstName,lastName,position,number,teamId FROM Player WHERE pid='".$pid."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $newfname = $row["firstName"];
		        $newlname = $row["lastName"]; 
		        $newposition = $row["position"];
		        $newnumber = $row["number"];
		        $newteamId = $row["teamId"];
		    }
		}
		return new Player($pid, $newfname, $newlname, $newposition, $newnumber, $newteamId);
	}

	public function updateTeam($teamId, $teamName, $uid, $location, $skill)
	{
		//update the fields of a team object
		if(isset($teamName)); {
			$this->conn->query("UPDATE Team SET teamName='".$teamName."' WHERE teamId='".$teamId."'");
		}
		if(isset($uid)); {
			$this->conn->query("UPDATE Team SET uid='".$uid."'' WHERE teamId='".$teamId."'");
		}
		if(isset($location)); {
			$this->conn->query("UPDATE Team SET locaiton='".$location."' WHERE teamId='".$teamId."'");
		}
		if(isset($skill)); {
			$this->conn->query("UPDATE Team SET skill='".$skill."'' WHERE teamId='".$teamId."'");
		}
		//get up to date values for the team object
		$result = $this->conn->query("SELECT uid,teamName,location,skill FROM Team WHERE teamId='".$teamId."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $newuid = $row["uid"];
		        $newname = $row["teamName"]; 
		        $newlocation = $row["location"];
		        $newskill = $row["skill"];
		    }
		}
		return new Team($newuid, $newname, $newlocation, $newskill, $teamId);
	}

	public function getTeamIds($uid)
	{
		//get all the team ids associated with a user
		$this->conn->query("SELECT teamId FROM Team WHERE uid='".$uid."'");
		if ($result->num_rows > 0) {
	    // output data of each row
		$arr = Array();
	    while($row = $result->fetch_assoc()) {
	        $arr[] = $row["teamId"];
	    }
	    return $arr;
		}
	}

	public function getGameIds($teamId)
	{
		//get all the game ids associated with a team
		$this->conn->query("SELECT gameId FROM Game WHERE teamId='".$teamId."'");
		if ($result->num_rows > 0) {
	    // output data of each row
		$arr = Array();
	    while($row = $result->fetch_assoc()) {
	        $arr[] = $row["gameId"];
	    }
	    return $arr;
		}
	}
	public function getGame($gameId)
	{
		$result = $this->conn->query("SELECT team1,team2 FROM Team WHERE gameId='".$gameId."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $team1 = $row["team1"];
		        $team2 = $row["team2"]; 
		    }
		}
		return new Game($team1, null, $team2, null, null, null, null);
	}

	public function getTeam($teamId)
	{
		$result = $this->conn->query("SELECT uid,teamName,location,skill FROM Team WHERE teamId='".$teamId."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $uid = $row["uid"];
		        $name = $row["teamName"]; 
		        $location = $row["location"];
		        $skill = $row["skill"];
		    }
		}
		return new Team($uid, $name, $location, $skill, $teamId);
	}

	public function getPlayer($pid)
	{
		$result = $this->conn->query("SELECT firstName,lastName,position,number,teamId FROM Player WHERE pid='".$pid."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $fname = $row["firstName"];
		        $lname = $row["lastName"]; 
		        $position = $row["position"];
		        $number = $row["number"];
		        $teamId = $row["teamId"];
		    }
		}
		return new Player($pid, $fname, $lname, $position, $number, $teamId);
	}

	public function getStat($statType, $pid, $gameId, $setNum, $playerScoreMin, $playerScoreMax, $opponentScoreMin, $opponentScoreMax, $scoreDifferenceMin, $scoreDifferenceMax)
	{
		//assuming statType and the min and maxes(can be equal if one value wanted) are always set
		if(isset($pid) && isset($gameID) && isset($setNum)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND gameId='" .$gameId."'AND setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($pid) && isset($gameId)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND gameId='" .$gameId."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($pid) && isset($setNum)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($gameId) && isset($setNum)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE gameId='" .$gameId."'AND setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($pid)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($gameId)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE gameId='" .$gameId."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($setNum)) {
			$result = $this->conn->query("SELECT value FROM Stat WHERE setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else {
			$result = $this->conn->query("SELECT value FROM Stat WHERE statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		$total = 0;
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $total += $row["value"];
		    }
		}
		return $total;
	}
}
?>