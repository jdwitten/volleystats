<?php
include 'DataInterface.php';
$data = new DataInterface();
$data->createUser("TJ", "Andrews","tjandrews", "123", "tjandrews1@gmail.com");
$data->createTeam("Tar Heels", "Chapel Hill", 4, 0);
$data->createPlayer("TJ", "Andrews", 1, 44, 0);
$data->createGame(0, "duke", 3, 25, 20, 25, null, null, 23, 25, 23, null, null, 1);
$data->createStat(0, 0, 1, 1, 12, 12, 1);
$data->getUser(0);
$data->getTeam(0);
$data->getPlayer(0);
$data->getStat(0);
$data->getTeamIds(0);
$data->getGameIds(0);
$data->updatePlayer(0,"Jonathan", "Witten", 1, 2, 0);
$data->updateTeam(0, "heels", 0, "nc", 3);
?>