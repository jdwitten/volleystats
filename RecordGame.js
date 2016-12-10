$(document).ready(function(){
	var team = new Team();
	var game = new Game();
	updateCurrentTeam(team);
	refreshGame(game);
	getPlayers(game);

	var StatClickState = "None";
	var SelectedPlayer = "";

	$("#modal-cancel").click(function(){
		$(".modal").hide();
	})
	$(document).on("click",".end-set-team1",function(){
		game.mySetsWon += 1;
		game.currentSet += 1;
		game.myCurrentScore = 0;
		game.opponentCurrentScore = 0;
		updateGame(game);
  		refreshGameLabels(game);
		$(".modal").hide();
	})
	$(document).on("click",".end-set-team2",function(){
		game.opponentSetsWon += 1;
		game.currentSet += 1;
		game.myCurrentScore = 0;
		game.opponentCurrentScore = 0;
		updateGame(game);
  		refreshGameLabels(game);
		$(".modal").hide();
	})
	$(document).on("click",".end-game-team1",function(){
		game.mySetsWon += 1;
		game.myCurrentScore = 0;
		game.opponentCurrentScore = 0;
		updateGame(game);
  		refreshGameLabels(game);
		$(".modal").hide();
		//Do some stuff here to end the game
		saveGame();
	})
	$(document).on("click",".end-game-team2",function(){
		game.opponentSetsWon += 1;
		game.myCurrentScore = 0;
		game.opponentCurrentScore = 0;
		updateGame(game);
  		refreshGameLabels(game);
		$(".modal").hide();
		saveGame();
		window.location.href = 'stats.php';
	})
	$(".activePlayer").click(function(){
		if(StatClickState == "None"){
			$(this).removeClass("grey");
			$(this).addClass("blue");
			StatClickState = "PlayerSelected";
			SelectedPlayer = $(this).attr("id");
		}
		else if(StatClickState == "PlayerSelected"){
			$("#"+ SelectedPlayer).removeClass("blue");
			$("#"+ SelectedPlayer).addClass("grey");
			$(this).removeClass("grey");
			$(this).addClass("blue");
			SelectedPlayer = $(this).attr("id");
		}
	})
	$(".stat-button").click(function(){
		if(StatClickState=="PlayerSelected"){
			var statCode = $(this).attr("id").split("Stat")[1];
			var activeIndex = parseInt(SelectedPlayer.split("activePlayer")[1]);
			var player = game.activePlayers[activeIndex];
			console.log(game);
			sendStat(player.id, statCode, 1, game.myCurrentScore, game.opponentCurrentScore, game.currentSet);
			console.log(SelectedPlayer + " performed stat with code: " + statCode);
			sendStat
			$("#"+ SelectedPlayer).removeClass("blue");
			$("#"+ SelectedPlayer).addClass("grey");
			SelectedPlayer = "";
			StatClickState = "None";
		}
	})

  	$('.dropdown-button').dropdown({
      	inDuration: 300,
      	outDuration: 225,
      	constrain_width: false, // Does not change width of dropdown to that of the activator
      	hover: true, // Activate on hover
      	gutter: 0, // Spacing from edge
      	belowOrigin: false, // Displays dropdown below the button
      	alignment: 'left' // Displays dropdown with edge aligned to the left of button
    	}
  	);
  	$("#minus_team1").click(function(){
  		game.subtractTeam1Score(1);
  		refreshGameLabels(game);
  	});
  	$("#add_team1").click(function(){
  		var result = game.addTeam1Score(1);
  		if(result == "EndSetTeam1"){
  			endSet(game,"team1");
  		}
  		else if(result == "EndGameTeam1"){
  			endGame(game, "team1");
  		}
  		updateGame(game);
  		refreshGameLabels(game);
  	});
   	$("#minus_team2").click(function(){
  		game.subtractTeam2Score(1);
  		refreshGameLabels(game);
  	});
  	$("#add_team2").click(function(){
  		var result = game.addTeam2Score(1);
  		if(result == "EndSetTeam2"){
  			endSet(game, "team2");
  		}
  		else if(result == "EndGameTeam2"){
  			endGame(game, "team2")
  		}
  		refreshGameLabels(game);
  	});
  	$(document).on("click",".sub", function(){
  		console.log("sub players");
  		var activeIndex = parseInt(SelectedPlayer.split("activePlayer")[1]);
  		var player = game.activePlayers[activeIndex];
  		subPlayers(player.id,$(this).attr("id"), game);
  	});

})

var saveGame = function(){
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "save_game"},
		datatype: 'json',
		success: function(data){ 
			console.log("Successfully saved the game");
			window.location.href = 'stats.php';
		},
		type: 'POST'
	});
}

var endSet = function(game, winner){
	$("#modal-header").empty();
	$("#modal-info").empty();
	$("#modal-team1-score").empty();
	$("#modal-team2-score").empty();
	$("#modal-continue").removeClass("end-game-team1");
	$("#modal-continue").removeClass("end-game-team2");
	$("#modal-continue").removeClass("end-set-team1");
	$("#modal-continue").removeClass("end-set-team2");
	$("#modal-header").append("End of Set " + game.currentSet);
	if(winner == "team1"){
		var proposedScore = game.myCurrentScore + 1;
		$("#modal-team1-score").append(game.myTeam+": " + proposedScore);
		$("#modal-team2-score").append(game.opponent+": " + game.opponentCurrentScore);
		$("#modal-continue").addClass("end-set-team1");
	}
	else if(winner == "team2"){
		var proposedScore = game.opponentCurrentScore + 1;
		$("#modal-team1-score").append(game.myTeam+": " + game.myCurrentScore);
		$("#modal-team2-score").append(game.opponent+": " + proposedScore);
		$("#modal-continue").addClass("end-set-team2");
	}
	$("#modal-info").append("Press Continue to move to the next set or press Cancel if you need to go back to the set");
	$(".modal").show();
}

var endGame = function(game, winner){
	$("#modal-header").empty();
	$("#modal-info").empty();
	$("#modal-team1-score").empty();
	$("#modal-team2-score").empty();
	$("#modal-continue").removeClass("end-game-team1");
	$("#modal-continue").removeClass("end-game-team2");
	$("#modal-continue").removeClass("end-set-team1");
	$("#modal-continue").removeClass("end-set-team2");
	$("#modal-header").append("Match Over!");
	if(winner == "team1"){
		var proposedScore = game.mySetsWon + 1;
		$("#modal-team1-score").append(game.myTeam+": " + proposedScore);
		$("#modal-team2-score").append(game.opponent+": " + game.opponentSetsWon);
		$("#modal-continue").addClass("end-game-team1");
	}
	if(winner == "team2"){
		var proposedScore = game.opponentSetsWon + 1;
		$("#modal-team1-score").append(game.myTeam+": " + game.mySetsWon);
		$("#modal-team2-score").append(game.opponent+": " + proposedScore);
		$("#modal-continue").addClass("end-game-team2");
	}
	$("#modal-info").append("Press Continue if you want to end the game or Cancel if you need to go back to the set");
	$(".modal").show();

}

var subPlayers = function(activeID, inactiveID, game){
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "sub_player",
				activeID: activeID,
				inactiveID: inactiveID
			},
		datatype: 'json',
		success: function(data){ 
			console.log(data);
			getPlayers(game);
		},
		type: 'POST'
		});
}

var sendStat = function(playerID, statCode, value, playerScore, opponentScore, setNum){
	console.log(opponentScore);
	if(statCode == StatType.KILL || statCode == StatType.HIT_ERROR){
		sendStat(playerID, StatType.HIT_ATTEMPT, 1, playerScore, opponentScore, setNum);
	}
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "add_stat",
				stat: statCode,
				player: playerID,
				value: value,
				pScore: playerScore,
				oScore: opponentScore,
				set: setNum
			},
		datatype: 'json',
		success: function(data){ 
			console.log("successfully uploaded stat")
			getGameStats();
			sendToast("Recorded stat");
		},
		type: 'POST'
		});
}
var getGameStats = function(){
	$.ajax({
	url: "VolleyAPI.php",
		data: { action: "game_stats"},
		datatype: 'json',
		success: function(data){ 
			console.log(data);
			buildTable(data.players);
		},
		type: 'GET'
		});
}
var updateGame = function(game){
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "update_game",
				myCurrentScore: game.myCurrentScore,
				opponentCurrentScore: game.opponentCurrentScore,
				mySetsWon: game.mySetsWon,
				opponentSetsWon: game.opponentSetsWon,
				currentSet: game.currentSet
			},
		datatype: 'json',
		success: function(data){ 
			getPlayers(game);
		},
		type: 'POST'
		});
}

var updateCurrentTeam = function(team){
		$.ajax({
			url: "VolleyAPI.php",
			data: { action: "current_team"},
			datatype: 'jsonp',
			success: function(data){ 
				team = parseTeam(data.team)
			},
			type: 'GET'
		});
}

var getPlayers = function(game){
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "active_players"},
		datatype: 'jsonp',
		success: function(data){ 
			var active_players = Array();
			for(var i=0; i<data.active_players.length; i++){
				game.activePlayers[i] = parsePlayer(data.active_players[i]);

			}
			resetActivePlayers(game.activePlayers);
			getInactivePlayers(game);
		},
		type: 'GET'
	});
}
var getInactivePlayers = function(game){
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "inactive_players"},
		datatype: 'jsonp',
		success: function(data){ 
			inactive_players = Array();
			for(var i=0; i<data.inactive_players.length; i++){
				game.inactivePlayers[i] = parsePlayer(data.inactive_players[i]);
			}
			rebuildSubDropdown(game);

		},
		type: 'GET'
	});
}

var refreshGame = function(game){
	$.ajax({
		url: "VolleyAPI.php",
		data: { action: "active_game"},
		datatype: 'jsonp',
		success: function(data){ 
			game = parseCurrentGame(data.active_game, game);
			refreshGameLabels(game);
			rebuildSubDropdown(game);
			getGameStats();
		},
		type: 'GET'
	});
}


var resetActivePlayers = function(active_players){
	if(active_players.length < 6) return false;
	$("#p1name").html(active_players[0].fname + " "+ active_players[0].lname);
	$("#p2name").html(active_players[1].fname + " "+ active_players[1].lname);
	$("#p3name").html(active_players[2].fname + " "+ active_players[2].lname);
	$("#p4name").html(active_players[3].fname + " "+ active_players[3].lname);
	$("#p5name").html(active_players[4].fname + " "+ active_players[4].lname);
	$("#p6name").html(active_players[5].fname + " "+ active_players[5].lname);
}

var buildTable = function(players){
		$("#stat_table tbody").empty();
		for(var i=0; i<players.length; i++){
			var row = $("<tr></tr>");
			var player = players[i];
			row.append("<td>" + player.first_name + " " + player.last_name + "</td>")
			row.append("<td>" + player.number + "</td>")
			row.append("<td>" + player.position + "</td>")
			row.append("<td>" + player.stats[StatType.KILL-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.HIT_ATTEMPT-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.HIT_ERROR-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.BLOCK-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.BLOCKING_ERROR-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.ASSIST-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.SET_ERROR-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.DIG-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.PASS_ERROR-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.ACE-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.SERVING_ERROR-1].value + "</td>")
			row.append("<td>" + player.stats[StatType.SERVING_ATTEMPT-1].value + "</td>")
			$("#stat_table").append(row);
		}
}

function sendToast(message){
	Materialize.toast(message,500,	 "rounded");
}

function refreshGameLabels(game){
	console.log(game);
	$("#team1_label").html(game.myTeam);
	$("#team2_label").html(game.opponent);
	$("#team1_score").html("<h3>"+game.myCurrentScore+"</h3>");
	$("#team2_score").html("<h3>"+game.opponentCurrentScore+"</h3>");
	$("#team1_sets").html("<h5 class='yellow-text'>"+game.mySetsWon+"</h5>");
	$("#team2_sets").html("<h5 class='yellow-text'>"+game.opponentSetsWon+"</h5>");
}

function rebuildSubDropdown(game){
	$("#subDropdown").empty();

	for(var i=0; i<game.inactivePlayers.length; i++){
		console.log("inactivePlayer");
		var player = game.inactivePlayers[i];
		$("#subDropdown").append("<li class='sub' id='"+player.id+"'>"+ player.fname+" " + player.lname + "</li>");
	}
}

