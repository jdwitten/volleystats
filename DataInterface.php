<?php
include_once 'User.php';
include_once 'Team.php';
include_once 'Player.php';
include_once 'Stat.php';
include_once 'VolleyConstants.php';

class DataInterface
{
	public function __construct()
	{
	
	}
	public function createUser($fname, $lname, $uname, $pass, $email)
	{
		//Do stuff here to check validation of User info

		//Try to insert new user into the database

		//Create and return a new user object

		return new User($fname, $lname, $uname, $pass, $email, 1);
	}

	public function getUser($uid)
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
	{

	}

	public function updatePlayer($player)
	{
		//update the fields of a player object
	}

	public function updateTeam($team)
	{
		//update the fields of a team object
	}

	public function getTeamIds($userId)
	{
		//get all the team ids associated with a user
		return array(1,2,3);
	}
	public function getTeam($teamId)
	{
		return new Team(1, "UNC Tarheels", "Chapel Hill", "Collegiate Club", 1);
	}
	public function getStat($pid, $stat)
	{
		return new Stat($stat,rand(1,15));
	}



}
?>