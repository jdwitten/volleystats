
var updateCurrentTeam = function(team){
		$.ajax({
			url: "VolleyAPI.php",
			data: { action: "current_team"},
			datatype: 'jsonp',
			success: function(data){ 
				team = parseTeam(data.team)
				team = calculateStats(team, 1,1,1,1,1);

			},
			type: 'GET'
		});
	}

var getGames = function(team){
		$.ajax({
			url: "VolleyAPI.php",
			data: { action: "game_info",
					teamId: team.id
			},
			datatype: 'jsonp',
			success: function(data){ 
				$("#game-options").empty();
				for(var i=0; i<data.games.length;i++){
					var game = new Game();
					parseCurrentGame(data.games[i], game);
					// add new option
					$("select").append($("<option id='game_"+ game.id+"'>"+game.opponent+"</option>"));
					// trigger event
					$("select").trigger('contentChanged');
				}
			},
			type: 'GET'
		});
	}

var calculateStats = function(team, teamID, gameIDs, sets, winningMargin, trailingMargin){
		$.ajax({
			url: "VolleyAPI.php",
			data: { action: "current_team_stats"},
			datatype: 'jsonp',
			success: function(data){
				team = parseTeam(data.team)
				buildTable(team);
				buildStartingOptions(team);
				getGames(team);
			},
			type: 'GET' 
		});
	}

var buildTable = function(team){
		console.log(team)
		$("#team_name").empty();
		$("#team_name").html(team.name);
		for(var i=0; i<team.players.length; i++){
			var row = $("<tr></tr>");
			var player = team.players[i];
			row.append("<td>" + player.fname + " " + player.lname + "</td>")
			row.append("<td>" + player.number + "</td>")
			row.append("<td>" + player.position + "</td>")
			row.append("<td>" + player.stats[StatType.KILL] + "</td>")
			row.append("<td>" + player.stats[StatType.HIT_ATTEMPT] + "</td>")
			row.append("<td>" + player.stats[StatType.HIT_ERROR] + "</td>")
			row.append("<td>" + player.stats[StatType.BLOCK] + "</td>")
			row.append("<td>" + player.stats[StatType.BLOCKING_ERROR] + "</td>")
			row.append("<td>" + player.stats[StatType.ASSIST] + "</td>")
			row.append("<td>" + player.stats[StatType.SET_ERROR] + "</td>")
			row.append("<td>" + player.stats[StatType.DIG] + "</td>")
			row.append("<td>" + player.stats[StatType.PASS_ERROR] + "</td>")
			row.append("<td>" + player.stats[StatType.ACE] + "</td>")
			row.append("<td>" + player.stats[StatType.SERVING_ERROR] + "</td>")
			row.append("<td>" + player.stats[StatType.SERVING_ATTEMPT] + "</td>")
			$("#stat_table").append(row);
		}
}





$(document).ready(function() {
	  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  	});
	$('select').on('contentChanged', function() {
  		// re-initialize (update)
  		$(this).material_select();
	});
    $('select').material_select();
    currentTeam = new Team();
    currentTeam  = calculateStats(currentTeam,1,1,1,1,1);  

    $("#filter-open").click(function(){
    	$(".modal").show();
    	$("#modal-overlay").show();
    })
  });




function getCurrentTeam(){

}


function buildStartingOptions(team){
	var container = $("#starting_options");
	container.empty();

	for(var i=0; i<team.players.length; i++){
		console.log(i);
		var player = team.players[i];
		var op = $("<p></p>");
		var input = $("<input type='checkbox' name='start_"+player.id+"' value='true' id='start_"+player.id+"'/>")
		var label = $("<label for='start_"+player.id+"'>"+player.fname+" "+player.lname+"</label>");
		op.append(input, label);
		container.append(op);
	}
}









