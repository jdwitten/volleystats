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
};


var updateCurrentTeam = function(team){
		$.ajax({
			url: "Team.php",
			data: { action: "get_current"},
			datatype: 'jsonp',
			success: function(data){ 
				team.user = data.team.user;
				team.players = data.team.players;
				team.skillLevel = data.team.skill;
				team.name = data.team.name;
				team.id = data.team.id;
				team.location = data.team.location;
				team = calculateStats(team, 1,1,1,1,1);

			},
			type: 'GET'
		});
	}

var calculateStats = function(team, teamID, gameIDs, sets, winningMargin, trailingMargin){
		/*
		if(teamID != this.currentTeam.id){
			return false;
		}
		*/
		$.ajax({
			url: "Team.php",
			data: { action: "calculate_stats"},
			datatype: 'jsonp',
			success: function(data){
				console.log(data);
				team.players = new Array();
				for(var i=0; i<data.team.players.length;i++){
					team.players.push(data.team.players[i]);
				}
				buildTable(team);
			},
			type: 'GET' 
		});
	}

var buildTable = function(team){
		$("#stats").append("<h1>" + team.name + "</h1>");
}





$(document).ready(function() {
    $('select').material_select();
    currentTeam = new Team();
    currentTeam  = updateCurrentTeam(currentTeam);  
  });




function getCurrentTeam(){

}


