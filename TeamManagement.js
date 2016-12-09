var buildEditPlayers = function(team){
	$("#player-collection").empty();
	console.log(team)
	var players = team.players;
	for(var i=0; i<players.length;i++){
		var player = players[i];
		console.log(player);
		var element = $("<li id='player_container_"+player.id+"'></li>");
		var header = $("<div class='collapsible-header'><i class='material-icons'>perm_identity</i>"+player.fname+" " + player.lname+"</div>")
		var body = $("<div class='collapsible-body'></div>");
		var row = $("<div class='row valign-wrapper'></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_first_name_"+player.id+"' type='text' value="+player.fname+"><label for='new_first_name'>First Name</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_last_name_"+player.id+"' type='text' value="+player.lname+"><label for='new_last_name'>Last Name</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_number_"+player.id+"' type='number' value="+player.number+"><label for='new_number'>Number</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_position_"+player.id+"' type='text' value="+player.position+"><label for='new_position'>Position</label></div>")
		row.append("<div class='col s2'><a class='btn-floating btn-small waves-effect waves-light blue valign edit-player' id='edit_player_"+player.id+"'><i class='material-icons'>input</i></a></div>")
		body.append(row);
		element.append(header, body);
		$("#player-collection").append(element);
	}
	Materialize.updateTextFields();
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
					$("#data-objects").append($("<option id='game_"+ game.id+"'>"+game.opponent+"</option>"));
					// trigger event
					$("#data-objects").trigger('contentChanged');
				}
			},
			type: 'GET'
		});
	}

var refreshTeam = function(team, gameID,setNum,yourMinScore, yourMaxScore, opponentMinScore, opponentMaxScore,
    					minScoreDifference, maxScoreDifference){
		$.ajax({
			url: "VolleyAPI.php",
			data: { action: "current_team_stats",
					gameID: gameID,
					setNum: setNum,
					yourMinScore: yourMinScore,
					yourMaxScore: yourMaxScore,
					opponentMinScore: opponentMinScore,
					opponentMaxScore: opponentMaxScore,
					minScoreDifference: minScoreDifference,
					maxScoreDifference: maxScoreDifference
			},
			datatype: 'jsonp',
			success: function(data){
				team = parseTeam(data.team)
				buildTable(team);
				buildStartingOptions(team);
				getGames(team);
				buildEditPlayers(team);
			},
			type: 'GET' 
		});
	}


var buildTable = function(team){
		$("#team_name").empty();
		$("#team_name").html(team.name);
		$("#stat_table tbody").empty();
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
    var currentTeam = new Team();
    currentTeam  = refreshTeam(currentTeam,"all","all",1,1,1,1,1,1);  

    $("#filter-open").click(function(){
    	$(".modal").show();
    	$("#modal-overlay").show();
    })
    $("#modal-filter").click(function(){
    	var gameID = $("#game-options").children(":selected").attr("id");
    	gameID = gameID.split("game_")[1];
    	var setNum = $("#set_num").val();
    	var yourMinScore = $("#your_min_score").val();
    	var yourMaxScore = $("#your_max_score").val();
    	var opponentMinScore = $("#opp_min_score").val();
    	var opponentMaxScore = $("#opp_max_score").val();
    	var minScoreDifference = $("#min_score_diff").val();
    	var maxScoreDifference = $("#max_score_diff").val();

    	refreshTeam(currentTeam, gameID,setNum,yourMinScore, yourMaxScore, opponentMinScore, opponentMaxScore,
    					minScoreDifference, maxScoreDifference);
    })
    $("#modal-cancel").click(function(){
    	$(".modal").hide();
    	$("#modal-overlay").hide();
    });
    $(document).on("click",".edit-player",function(){
    	console.log("clicked edit player");
    	var id = $(this).attr("id").split("edit_player_")[1];
    	var fname = $("#new_first_name_"+id).val();
    	var lname = $("#new_last_name_"+id).val();
    	var num = $("#new_number_"+id).val();
    	var position = $("#new_position_"+id).val();
    	currentTeam = refreshTeam()
    	updatePlayer(currentTeam, id, fname, lname, num, position);
    })
  });

var updatePlayer = function(team, id, fname, lname, num, position){
	$.ajax({
			url: "VolleyAPI.php",
			data: { action: "update_player",
					pid: id,
					fname: fname,
					lname: lname,
					position: position,
					number: num,
					teamId: team.id,
			},
			datatype: 'jsonp',
			success: function(data){
				team = refreshTeam(team);
				console.log("updated Player");
			},
			type: 'POST' 
		});
}

function buildStartingOptions(team){
	var container = $("#starting_options");
	container.empty();

	for(var i=0; i<team.players.length; i++){
		var player = team.players[i];
		var op = $("<p></p>");
		var input = $("<input type='checkbox' name='start_"+player.id+"' value='true' id='start_"+player.id+"'/>")
		var label = $("<label for='start_"+player.id+"'>"+player.fname+" "+player.lname+"</label>");
		op.append(input, label);
		container.append(op);
	}
}









