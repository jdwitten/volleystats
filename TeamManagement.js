var currentUserId;
var currentTeam;
var buildEditTeams = function(teams){
	$("#team-collection").empty();
	console.log(teams)
	var element, header, body, row;
	for(var i=0; i<teams.length;i++){
		let team = teams[i];
		element = $("<li id='team_container_"+team.id+"'></li>");
		header = $("<div class='collapsible-header'><i class='material-icons'>supervisor_account</i>"+team.name+"</div>")
		body = $("<div class='collapsible-body'></div>");
		row = $("<div class='row valign-wrapper'></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_team_name_"+team.id+"' type='text' value='"+team.name+"'><label for='new_team_name'>Name</label></div>")
		row.append("<div class='input-field col s2 valign'><select  id='new_skill_"+team.id+"' value='"+team.skillLevel+"'><option value='1'>RECREATION</option><option value='2'>MIDDLE SCHOOL</option><option value='3'>HIGH SCHOOL</option><option value='4'>COLLEGIATE</option><option value='5'>CLUB U12</option><option value='6'>CLUB U13</option><option value='7'>CLUB U14</option><option value='8'>CLUB U15</option><option value='9'>CLUB U16</option>'<option value='10'>CLUB U17</option><option value='11'>CLUB U18</option><option value='12'>CLUB U19</option>)</select><label>Skill Level</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_location_"+team.id+"' type='text' value='"+team.location+"'><label for='new_location'>Location</label></div>")
		row.append("<div class='col s2'><a class='btn-floating btn-small waves-effect waves-light blue valign edit-team' id='edit_team_"+team.id+"'><i class='material-icons'>input</i></a></div>")
		row.append("<div class='col s2'><a class='btn-floating btn-small waves-effect waves-light blue valign edit-team' id='edit_team_"+team.id+"'><i class='material-icons'>delete</i></a></div>")
		body.append(row);

		element.append(header, body);
		$("#team-collection").append(element);
		$("#edit_team_"+team.id).bind("click",function(){
			console.log("clicked edit team");
    		//var id = $(button).attr("id").split("edit_player_")[1];
    		var name = $("#new_team_name_"+team.id).val();
    		var skillLevel = $("#new_skill_"+team.id).val();
    		var location = $("#new_location_"+team.id).val();
    		updateTeam(team.id, name, skillLevel, location, currentUserId);
		})
	}
	element = $("<li id='add_team_container'></li>");
	header = $("<div class='collapsible-header green-text'><i class='material-icons'>add</i>Add Team</div>")
	body = $("<div class='collapsible-body'></div>");
	row = $("<div class='row valign-wrapper'></div>")
	row.append("<div class='input-field col s2 valign'><input id='add_team_name' type='text'><label for='new_team_name'>Name</label></div>")
	row.append("<div class='input-field col s2 valign'><select  id='add_team_skill'><option value='' disabled selected>Select</option><option value='1'>RECREATION</option><option value='2'>MIDDLE SCHOOL</option><option value='3'>HIGH SCHOOL</option><option value='4'>COLLEGIATE</option><option value='5'>CLUB U12</option><option value='6'>CLUB U13</option><option value='7'>CLUB U14</option><option value='8'>CLUB U15</option><option value='9'>CLUB U16</option>'<option value='10'>CLUB U17</option><option value='11'>CLUB U18</option><option value='12'>CLUB U19</option>)</select><label>Skill Level</label></div>")
	row.append("<div class='input-field col s2 valign'><input id='add_team_location' type='text'><label for='new_location'>Location</label></div>")
	row.append("<div class='col s2'><a class='btn-floating btn-small waves-effect waves-light blue valign add-tea,' id='add-team'><i class='material-icons'>add</i></a></div>")
	body.append(row);
	element.append(header, body);
	$("#team-collection").append(element);
	$("#add-team").bind("click",function(){
		console.log("clicked edit team");
    	//var id = $(button).attr("id").split("edit_player_")[1];
    	var name = $("#add_team_name").val();
    	var skillLevel = $("#add_team_skill").val();
    	var location = $("#add_team_location").val();
    	addTeam(name, skillLevel, location, currentUserId);
	})
	$('select').material_select();
	Materialize.updateTextFields();
}

var buildEditPlayers = function(team){
	$("#player-collection").empty();
	console.log(team)
	var players = team.players;
	var element, header, body, row;
	for(var i=0; i<players.length;i++){
		let player = players[i];
		element = $("<li id='player_container_"+player.id+"'></li>");
		header = $("<div class='collapsible-header'><i class='material-icons'>perm_identity</i>"+player.fname+" " + player.lname+"</div>")
		body = $("<div class='collapsible-body'></div>");
		row = $("<div class='row valign-wrapper'></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_first_name_"+player.id+"' type='text' value='"+player.fname+"'><label for='new_first_name'>First Name</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_last_name_"+player.id+"' type='text' value='"+player.lname+"'><label for='new_last_name'>Last Name</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_number_"+player.id+"' type='number' value='"+player.number+"'><label for='new_number'>Number</label></div>")
		row.append("<div class='input-field col s2 valign'><input id='new_position_"+player.id+"' type='text' value='"+player.position+"'><label for='new_position'>Position</label></div>")
		row.append("<div class='col s2'><a class='btn-floating btn-small waves-effect waves-light blue valign edit-player' id='edit_player_"+player.id+"'><i class='material-icons'>input</i></a></div>")
		body.append(row);
		element.append(header, body);
		$("#player-collection").append(element);
		$("#edit_player_"+player.id).bind("click",function(){
			console.log("clicked edit player");
    		//var id = $(button).attr("id").split("edit_player_")[1];
    		var fname = $("#new_first_name_"+player.id).val();
    		var lname = $("#new_last_name_"+player.id).val();
    		var num = $("#new_number_"+player.id).val();
    		var position = $("#new_position_"+player.id).val();
    		console.log(fname, lname, player.id, num, position);
    		updatePlayer(team,player.id, fname, lname, num, position);
		})
	}
	element = $("<li id='add_player_container'></li>");
	header = $("<div class='collapsible-header green-text'><i class='material-icons'>add</i>Add Player</div>")
	body = $("<div class='collapsible-body'></div>");
	row = $("<div class='row valign-wrapper'></div>")
	row.append("<div class='input-field col s2 valign'><input id='add_player_fname' type='text'><label for='new_first_name'>First Name</label></div>")
	row.append("<div class='input-field col s2 valign'><input id='add_player_lname' type='text'><label for='new_last_name'>Last Name</label></div>")
	row.append("<div class='input-field col s2 valign'><input id='add_player_number' type='number'><label for='new_number'>Number</label></div>")
	row.append("<div class='input-field col s2 valign'><input id='add_player_position' type='text'><label for='new_position'>Position</label></div>")
	row.append("<div class='col s2'><a class='btn-floating btn-small waves-effect waves-light blue valign add-player' id='add-player'><i class='material-icons'>add</i></a></div>")
	body.append(row);
	element.append(header, body);
	$("#player-collection").append(element);
	$("#add-player").bind("click",function(){
			console.log("clicked edit player");
    		//var id = $(button).attr("id").split("edit_player_")[1];
    		var fname = $("#add_player_fname").val();
    		var lname = $("#add_player_lname").val();
    		var num = $("#add_player_number").val();
    		var position = $("#add_player_position").val();
    		addPlayer(team, fname, lname, num, position);
		})
	Materialize.updateTextFields();
}

var addPlayer = function(team, fname, lname, num, position){
	$.ajax({
			url: "VolleyAPI.php",
			data: { action: "create_player",
					fname: fname,
					lname: lname,
					position: position,
					number: num,
					teamId: team.id
			},
			datatype: 'jsonp',
			success: function(data){ 
				team = refreshTeam(team, "All","All",0, 100, 0, 100,
    					-100, 100);
				console.log("Added Player");
			},
			type: 'POST'
		});
}
var addTeam = function(teamName, skillLevel, location, uid){
	$.ajax({
			url: "VolleyAPI.php",
			data: { action: "create_team",
					teamName: teamName,
					location: location,
					skill: skillLevel,
					uid: uid

			},
			datatype: 'jsonp',
			success: function(data){ 
				currentTeam = refreshTeam(currentTeam, "All","All",0, 100, 0, 100,
    					-100, 100);
				console.log("Added Team");
				getPlayerTeams(currentUserId);
			},
			type: 'POST'
		});
}
var updateTeam = function(id, teamName, skillLevel, location, uid){
	$.ajax({
			url: "VolleyAPI.php",
			data: { action: "update_team_info",
					teamId: id,
					teamName: teamName,
					location: location,
					skill: skillLevel,
					uid: uid
			},
			datatype: 'jsonp',
			success: function(data){
				currentTeam = refreshTeam(currentTeam, "All","All",0, 100, 0, 100,
    					-100, 100);
				getPlayerTeams(currentUserId)
				console.log("updated Player");
				Materialize.toast("Switched Team", 3000, "rounded");
			},
			type: 'POST' 
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
				console.log(data)
				$("#game-options").empty();
				$("#game-options").append("<option value='All' id='All' >All</option>");
				for(var i=0; i<data.games.length;i++){
					var game = new Game();
					parseCurrentGame(data.games[i], game);
					// add new option
					$("#game-options").append($("<option id='game_"+ game.id+"'>"+game.opponent+"</option>"));
					// trigger event
					$("#game-options").trigger('contentChanged');
				}
			},
			type: 'GET'
		});
	}

var getCurrentUser = function(){
	$.ajax({
			url: "VolleyAPI.php",
			data: { action: "current_user"},
			datatype: 'jsonp',
			success: function(data){ 
				currentUserId = data.id;
				console.log(currentUserId);
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
				if(data.team){
					currentTeam = parseTeam(data.team);

					buildTable(currentTeam);
					buildStartingOptions(currentTeam);
					getGames(currentTeam);
					buildEditPlayers(currentTeam);
					$(".modal").hide();
					$("#modal-overlay").hide();
				}
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
			row.append("<td>" + positionToString(player.position) + "</td>")
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

var getPlayerTeams = function(uid){
	$.ajax({
			url: "VolleyAPI.php",
			data: { action: "all_teams",
					uid: uid
			},
			datatype: 'jsonp',
			success: function(data){
				var teams = Array();
				for(var i=0; i<data.teams.length; i++){
					teams.push(parseTeam(data.teams[i]));
				}
				buildEditTeams(teams);
			},
			type: 'GET' 
		});
}

$(document).ready(function() {
	getCurrentUser();
	  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  	});
	$(document).on('contentChanged','select', function() {
  		// re-initialize (update)
  		$(this).material_select();
	});
    $('select').material_select();
    currentTeam = new Team();
    currentTeam  = refreshTeam(currentTeam,"All","All",1,1,1,1,1,1);  
    $("#filter-open").click(function(){
    	$(".modal").show();
    	$("#modal-overlay").show();
    })
    $("#modal-filter").click(function(){
    	var gameID = $("#game-options").children(":selected").attr("id");
    	if(gameID!="All"){
    		gameID = gameID.split("game_")[1];
    		gameID = parseInt(gameID);
    	}
    	var setNum = $("#set_num").val();
    	if(setNum!="All"){
    		setNum = parseInt(setNum);
    		if(setNum <1 || setNum > 5) return;
    	}
    	var yourMinScore = $("#your_min_score").val();
    	var yourMaxScore = $("#your_max_score").val();
    	var opponentMinScore = $("#opp_min_score").val();
    	var opponentMaxScore = $("#opp_max_score").val();
    	var minScoreDifference = $("#min_score_diff").val();
    	var maxScoreDifference = $("#max_score_diff").val();
    	console.log(gameID, setNum);

    	refreshTeam(currentTeam, gameID,setNum,yourMinScore, yourMaxScore, opponentMinScore, opponentMaxScore,
    					minScoreDifference, maxScoreDifference);
    })
    $("#modal-cancel").click(function(){
    	$(".modal").hide();
    	$("#modal-overlay").hide();
    });
    $(".sort-header").click(function() {
        var headerType = $(this).attr("id").split("type_")[1];
            sortTable(currentTeam, headerType);
    })
    $("#team-tab").click(function(){
    	getPlayerTeams(currentUserId);
    })
  });
var editPlayer = function(id, team){
    	console.log("clicked edit player");
    	//var id = $(button).attr("id").split("edit_player_")[1];
    	var fname = $("#new_first_name_"+id).val();
    	var lname = $("#new_last_name_"+id).val();
    	var num = $("#new_number_"+id).val();
    	var position = $("#new_position_"+id).val();
    	updatePlayer(team,id, fname, lname, num, position);
    }
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
				team = refreshTeam(team, "All","All",0, 100, 0, 100,
    					-100, 100);
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
var compareKill = function(a,b) {
    if (a.stats[StatType.KILL] < b.stats[StatType.KILL]) {
          return -1;
        }    
      if (a.stats[StatType.KILL] > b.stats[StatType.KILL]) {
        return 1;
    }
  return 0;
}
var compareHitAttempt = function(a,b) {
    if (a.stats[StatType.HIT_ATTEMPT] < b.stats[StatType.HIT_ATTEMPT]) {
          return -1;
        }    
      if (a.stats[StatType.HIT_ATTEMPT] > b.stats[StatType.HIT_ATTEMPT]) {
        return 1;
    }
  return 0;
}
var compareHitError = function(a,b) {
    if (a.stats[StatType.HIT_ERROR] < b.stats[StatType.HIT_ERROR]) {
          return -1;
        }    
      if (a.stats[StatType.HIT_ERROR] > b.stats[StatType.HIT_ERROR]) {
        return 1;
    }
  return 0;
}
var compareBlock = function(a,b) {
    if (a.stats[StatType.BLOCK] < b.stats[StatType.BLOCK]) {
          return -1;
        }    
      if (a.stats[StatType.BLOCK] > b.stats[StatType.BLOCK]) {
        return 1;
    }
  return 0;
}
var compareBlockingError = function(a,b) {
    if (a.stats[StatType.BLOCKING_ERROR] < b.stats[StatType.BLOCKING_ERROR]) {
          return -1;
        }    
      if (a.stats[StatType.BLOCKING_ERROR] > b.stats[StatType.BLOCKING_ERROR]) {
        return 1;
    }
  return 0;
}
var compareAssist = function(a,b) {
    if (a.stats[StatType.ASSIST] < b.stats[StatType.ASSIST]) {
          return -1;
        }    
      if (a.stats[StatType.ASSIST] > b.stats[StatType.ASSIST]) {
        return 1;
    }
  return 0;
}
var compareSetError = function(a,b) {
    if (a.stats[StatType.SET_ERROR] < b.stats[StatType.SET_ERROR]) {
          return -1;
        }    
      if (a.stats[StatType.SET_ERROR] > b.stats[StatType.SET_ERROR]) {
        return 1;
    }
  return 0;
}
var compareDig = function(a,b) {
    if (a.stats[StatType.DIG] < b.stats[StatType.DIG]) {
          return -1;
        }    
      if (a.stats[StatType.DIG] > b.stats[StatType.DIG]) {
        return 1;
    }
  return 0;
}
var comparePassError = function(a,b) {
    if (a.stats[StatType.PASS_ERROR] < b.stats[StatType.PASS_ERROR]) {
          return -1;
        }    
      if (a.stats[StatType.PASS_ERROR] > b.stats[StatType.PASS_ERROR]) {
        return 1;
    }
  return 0;
}
var compareAce = function(a,b) {
    if (a.stats[StatType.ACE] < b.stats[StatType.ACE]) {
          return -1;
        }    
      if (a.stats[StatType.ACE] > b.stats[StatType.ACE]) {
        return 1;
    }
  return 0;
}
var compareServingError = function(a,b) {
    if (a.stats[StatType.SERVING_ERROR] < b.stats[StatType.SERVING_ERROR]) {
          return -1;
        }    
      if (a.stats[StatType.SERVING_ERROR] > b.stats[StatType.SERVING_ERROR]) {
        return 1;
    }
  return 0;
}
var compareServingAttempt = function(a,b) {
    if (a.stats[StatType.SERVING_ATTEMPT] < b.stats[StatType.SERVING_ATTEMPT]) {
          return -1;
        }    
      if (a.stats[StatType.SERVING_ATTEMPT] > b.stats[StatType.SERVING_ATTEMPT]) {
        return 1;
    }
  return 0;
}
var compareName = function(a,b) {
    if (a.name < b.name) {
          return -1;
        }    
      if (a.name > b.name) {
        return 1;
    }
  return 0;
}

var sortTable = function(team, statType){
        if(statType == StatType.Kill){
            team.players = team.players.sort(compareKill);
        }
        else if(statType == StatType.HIT_ATTEMPT){
            team.players = team.players.sort(compareHitAttempt);
        }
        else if(statType == StatType.HIT_ERROR){
            team.players = team.players.sort(compareHitError);
        }
        else if(statType == StatType.BLOCK){
            team.players = team.players.sort(compareBlock);
        }
        else if(statType == StatType.BLOCKING_ERROR){
            team.players = team.players.sort(compareBlockingError);
        }
        else if(statType == StatType.ASSIST){
            team.players = team.players.sort(compareAssist);
        }
        else if(statType == StatType.DIG){
            team.players = team.players.sort(compareDig);
        }
        else if(statType == StatType.PASS_ERROR){
            team.players = team.players.sort(comparePassError);
        }
        else if(statType == StatType.ACE){
            team.players = team.players.sort(compareAce);
        }
        else if(statType == StatType.SERVING_ERROR){
            team.players = team.players.sort(compareServingError);
        }
        else if(statType == StatType.SERVING_ATTEMPT){
            team.players = team.players.sort(compareServingAttempt);
        }
        else {
            team.players = team.players.sort(compareName)
        }
        buildTable(team);
}










