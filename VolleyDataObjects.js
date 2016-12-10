//Class definitions

var Team = function(){
	this.user = "";
	this.players = "";
	this.skillLevel = "";
	this.name = "";
	this.id = 0;
	this.location = "";
};

var Player = function(){
	this.fname = "";
	this.lname = "";
	this.id = "";
	this.position = "";
	this.number = "";
	this.stats = [];
};

var Game = function(){
	this.id = 0;
	this.myTeam = "";
	this.opponent = "";
	this.currentSet = 0;
	this.myCurrentScore = 0;
	this.opponentCurrentScore = 0;
	this.opponentSetsWon = 0;
	this.mySetsWon = 0;
	this.maxSets = 0;
	this.activePlayers = new Array(6);
	this.inactivePlayers = new Array();

	this.replaceActivePlayer = function(player, index){
		if(index>5) return false;
		this.activePlayers[index] = player;
	}

	this.addTeam1Score = function(add){
		var newScore = this.myCurrentScore + add;
		if((newScore >= 25 && newScore - this.opponentCurrentScore > 1 && this.currentSet<this.maxSets) ||
			newScore >= 15 && newScore - this.opponentCurrentScore>1 && this.currentSet==this.maxSets){
			var newSets = this.mySetsWon + 1;
			if(this.maxSets==1 && newSets >= 1){
				return "EndGameTeam1";
			}
			else if(this.maxSets == 3 && newSets==2){
				return "EndGameTeam1";
			}
			else if(this.maxSets == 5 && newSets==3){
				return "EndGameTeam1";
			}
			else{
				return "EndSetTeam1";
			}
		}
		else{
			this.myCurrentScore = newScore;
			return "Continue";
		}
	}
	this.subtractTeam1Score = function(sub){
		var newScore = this.myCurrentScore - sub;
		if(newScore < 0) return false;
		else{
			this.myCurrentScore = newScore;
		}
	}
	this.addTeam2Score = function(add){
		var newScore = this.opponentCurrentScore + add;
		if((newScore >= 25 && newScore - this.myCurrentScore > 1 && this.currentSet<this.maxSets) ||
			newScore >= 15 && newScore - this.myCurrentScore>1 && this.currentSet==this.maxSets){
			var newSets = this.opponentSetsWon + 1;
			if(this.maxSets==1 && newSets >= 1){
				return "EndGameTeam2";
			}
			else if(this.maxSets == 3 && newSets==2){
				return "EndGameTeam2";
			}
			else if(this.maxSets == 5 && newSets==3){
				return "EndGameTeam2";
			}
			else{
				return "EndSetTeam2"
			}
		}
		else{
			this.opponentCurrentScore = newScore;
			return "Continue";
		}
	}
	this.subtractTeam2Score = function(sub){
		var newScore = this.opponentCurrentScore - sub;
		if(newScore < 0) return false;
		else{
			this.opponentCurrentScore = newScore;
		}
	}

}

function parseTeam(json_team){
	var team = new Team();
	team.user = json_team.user;
	var json_players = json_team.players;
	var players = [];
	for(var i=0; i<json_players.length;i++){
		players.push(parsePlayer(json_players[i]));
	}
	team.players = players;
	team.skillLevel = json_team.skill;
	team.name = json_team.name;
	team.id = json_team.id;
	team.location = json_team.location;
	return team;
}

function parsePlayer(json_player){
	var player = new Player();
	player.fname = json_player.first_name;
	player.lname = json_player.last_name;
	player.id = json_player.id;
	player.position = json_player.position;
	player.number = json_player.number;
	player.stats = {};
	for(var j=0; j<json_player.stats.length; j++){
		player.stats[json_player.stats[j].stat_code] = json_player.stats[j].value;
	}
	return player;
}

function parseCurrentGame(json_game, game){
	game.myTeam = json_game.team1Name;
	game.opponent = json_game.team2Name;
	game.currentSet = parseInt(json_game.currentSet);
	game.myCurrentScore = parseInt(json_game.myCurrentScore);
	game.opponentCurrentScore = parseInt(json_game.opponentCurrentScore);
	game.mySetsWon = parseInt(json_game.mySetsWon);
	game.opponentSetsWon = parseInt(json_game.opponentSetsWon);
	game.maxSets = parseInt(json_game.maxSets);
	game.id = parseInt(json_game.gameID);
	return game;
}

function skillToString(skillLevel){
    if(skillLevel == 1) {
        return "Recreation";
    } 
    else if(skillLevel ==2) {
        return "Middle School";
    }
    else if(skillLevel ==3) {
        return "High School ";
    }
    else if(skillLevel ==4) {
        return "Collegiate";
    }
    else if(skillLevel ==5) {
        return "Club U12";
    }
    else if(skillLevel ==6) {
        return "Club U13";
    }
    else if(skillLevel ==7) {
        return "Club U14";
    }
    else if(skillLevel ==8) {
        return "Club U15";
    }
    else if(skillLevel ==9) {
        return "Club U16";
    }
    else if(skillLevel ==10) {
        return "Club U17";
    }
    else if(skillLevel ==11) {
        return "Club U18";
    }
    else if(skillLevel ==12) {
        return "Club U19";
    }
    else {
        return "Other";
    }
}

function positionToString(position){
    if(position == 1) {
        return "OH";
    } 
    else if(position ==2) {
        return "S";
    }
    else if(position ==3) {
        return "OPP";
    }
    else if(position ==4) {
        return "L";
    }
    else if(position ==5) {
        return "DS";
    }
    else if(position ==6) {
        return "MB";
    }
    else {
        return "Other";
    }
}

