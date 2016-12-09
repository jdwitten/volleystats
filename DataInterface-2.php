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
		$query_result = $conn->query("SELECT userName FROM User WHERE userName='".$uname."'");
		if($query_result->num_rows == 0) {
			$hashpass = md5($uname."-salt".$pass);
			$sql = "INSERT INTO User (firstName, lastName, email, userName, password) VALUES ('".$fname."','".$lname."','".$email."','".$uname."','".$hashpass."')";
			$result = $conn->query($sql);
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
		$conn = $this->conn;
		$sql = "INSERT INTO Game (team1, team2, setsPlayed, team1set1score, team1set2score, team1set3score, team1set4score, team1set5score, team2set1score, team2set2score, team2set3score, team2set4score, team2set5score, winningTeam) VALUES ('".$team1."',' ".$team2."','".$setsPlayed."','".$team1Set1Score."',' ".$team1Set2Score."',' ".$team1Set3Score."',' ".$team1Set4Score."',' ".$team1Set5Score."',' ".$team2Set1Score."',' ".$team2Set2Score."',' ".$team2Set3Score."',' ".$team2Set4Score."',' ".$team2Set5Score."',' ".$winningTeam."')";
		  if ($conn->query($sql)) {
		  	$gameId = $conn->insert_id;
		  }
		return true;
	}

	public function createStat($pid, $gameId, $statType, $setNum, $playerScore, $opponentScore, $value)
	{
		$conn = $this->conn;
		$sql = "INSERT INTO Stat (pid, gameId, statType, setNum, playerScore, opponentScore, value) VALUES ('".$pid."',' ".$gameId."','".$statType."','".$setNum."',' ".$playerScore."',' ".$opponentScore."',' ".$value."')";
		  if ($conn->query($sql)) {
		  	$statId = $conn->insert_id;
		  }
		  return new Stat($statType, $value);
	}

	public function createTeam($name, $location, $skill, $uid)
	{
		//Try to create a new team in the database
		$conn = $this->conn;
		$sql = "INSERT INTO Team (uid, teamName, location, skill) VALUES ('".$uid."',' ".$name."','".$location."','".$skill."')";
		  if ($conn->query($sql)) {
		  	$teamId = $conn->insert_id;
		  }
		//Return a new Team object
		return new Team($uid, $name, $location, $skill, $teamId);
	}

	public function createPlayer($fname, $lname, $position, $number, $teamId)
	{
		$conn = $this->conn;
		$sql = "INSERT INTO Player (firstName, lastName, position, number, teamId) VALUES ('".$fname."','".$lname."','".$position."','".$number."','".$teamId."')";
		  if ($conn->query($sql)) {
		  	$playerId = $conn->insert_id;
			}
		return new Player($playerId, $fname, $lname, $position, $number, $teamId);
	}

	public function getUser($uid)
	{
		$conn = $this->conn;
		$result = $conn->query("SELECT firstName,lastName,email,userName,password FROM User WHERE uid='".$uid."'");
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        $fname = $row["firstName"];
		        $lname = $row["lastName"]; 
		        $email = $row["email"];
		        $uname = $row["userName"];
		        $pass = $row["password"];
		    }
		}
		return new User($fname, $lname, $uname, $pass, $email, $uid);
	}

	public function updatePlayer($pid, $fname, $lname, $position, $number, $teamId)
	{
		//update the fields of a player object
		$conn = $this->conn;
		if(isset($fname)); {
			$conn->query("UPDATE Player SET firstName='".$fname."' WHERE pid='".$pid."'");
		}
		if(isset($lname)); {
			$conn->query("UPDATE Player SET lastName='".$lname."' WHERE pid='".$pid."'");
		}
		if(isset($position)); {
			$conn->query("UPDATE Player SET position='".$position."' WHERE pid='".$pid."'");
		}
		if(isset($number)); {
			$conn->query("UPDATE Player SET number='".$number."' WHERE pid='".$pid."'");
		}
		if(isset($teamId)); {
			$conn->query("UPDATE Player SET teamId='".$teamId."' WHERE pid='".$pid."'");
		}
		//get up to date values for the player object
		$result = $conn->query("SELECT firstName,lastName,position,number,teamId FROM Player WHERE pid='".$pid."'");
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
		$conn = $this->conn;
		if(isset($teamName)); {
			$conn->query("UPDATE Team SET teamName='".$teamName."' WHERE teamId='".$teamId."'");
		}
		if(isset($uid)); {
			$conn->query("UPDATE Team SET uid='".$uid."' WHERE teamId='".$teamId."'");
		}
		if(isset($location)); {
			$conn->query("UPDATE Team SET location='".$location."' WHERE teamId='".$teamId."'");
		}
		if(isset($skill)); {
			$conn->query("UPDATE Team SET skill='".$skill."' WHERE teamId='".$teamId."'");
		}
		//get up to date values for the team object
		$result = $conn->query("SELECT uid,teamName,location,skill FROM Team WHERE teamId='".$teamId."'");
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
		$conn = $this->conn;
		$result = $conn->query("SELECT teamId FROM Team WHERE uid='".$uid."'");
		if ($result->num_rows > 0) {
	    // output data of each row
		$arr = Array();
	    while($row = $result->fetch_assoc()) {
	        $arr[] = intval($row["teamId"]);
	    }
	    return $arr;
		}
	}

	public function getGameIds($teamId)
	{
		//get all the game ids associated with a team
		$conn = $this->conn;
		$result = $conn->query("SELECT gameId FROM Game WHERE team1='".$teamId."'");
		if ($result->num_rows > 0) {
	    // output data of each row
		$arr = Array();
	    while($row = $result->fetch_assoc()) {
	        $arr[] = intval($row["gameId"]);
	    }
	    return $arr;
		}
	}
	public function getGame($gameId)
	{
		$conn = $this->conn;
		$result = $conn->query("SELECT team1,team2 FROM Team WHERE gameId='".$gameId."'");
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
		$conn = $this->conn;
		$result = $conn->query("SELECT uid,teamName,location,skill FROM Team WHERE teamId='".$teamId."'");
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
		$conn = $this->conn;
		$result = $conn->query("SELECT firstName,lastName,position,number,teamId FROM Player WHERE pid='".$pid."'");
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
		$conn = $this->conn;
		//assuming statType and the min and maxes(can be equal if one value wanted) are always set
		if(isset($pid) && isset($gameID) && isset($setNum)) {
			$result = $conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND gameId='" .$gameId."'AND setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($pid) && isset($gameId)) {
			$result = $conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND gameId='" .$gameId."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($pid) && isset($setNum)) {
			$result = $conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($gameId) && isset($setNum)) {
			$result = $conn->query("SELECT value FROM Stat WHERE gameId='" .$gameId."'AND setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($pid)) {
			$result = $conn->query("SELECT value FROM Stat WHERE pid='".$pid."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($gameId)) {
			$result = $conn->query("SELECT value FROM Stat WHERE gameId='" .$gameId."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else if(isset($setNum)) {
			$result = $conn->query("SELECT value FROM Stat WHERE setNum='".$setNum."'AND statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
		}
		else {
			$result = $conn->query("SELECT value FROM Stat WHERE statType='".$statType."'AND playerScore>='".$playerScoreMin."'AND playerScore<='".$playerScoreMax."'AND opponentScore>='".$opponentScoreMin."'AND opponentScore<='".$opponentScoreMax."'AND (playerScore-opponentScore)>='".$scoreDifferenceMin."'AND (playerScore-opponentScore)<='".$scoreDifferenceMax."'");
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