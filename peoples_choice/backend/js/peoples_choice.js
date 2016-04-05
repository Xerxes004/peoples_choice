$(document).ready(function(){

	/********************************************************************************
	 * Header and modal functions
	 ********************************************************************************/
  $('#login-modal').on('shown.bs.modal', function () {
    $('#username').focus();
  });

  // Logs a user out when clicked in the menu
  $("#user-logout").click(function(evt){
    $.post('index.php', {action:"LOGOUT"});
    window.location.reload();
    $("#login-field").removeClass('hidden');
    $("#user-tab").addClass('hidden');
    $("#admin-link-header").addClass('hidden');
  });

  // Handles the submission of the login modal
  $("#login-form").submit(function(evt){
    evt.preventDefault();

    var uname = $("#username").val();
    var pass = Sha256.hash($("#password").val());
    console.log(pass);
    
    $.post('index.php',{action:"LOGIN", username:uname, password:pass}, function(data){
      var result = JSON.parse(data);
      if(result['login'] == true){
      	if(result['isAdmin']){
      		$("#admin-link-header").removeClass('hidden');
      	}
        var userTab = $("#user-tab");
        userTab.text(result['user']);
        userTab.append("<span class='caret'></span>")
        userTab.removeClass('hidden');
        $("#login-field").addClass('hidden');
        $("#login-modal").modal('hide');
      }else{
        var msg = '<div class="alert alert-danger" role="alert">Name and Password do not match</div>';
        var error = $(".login-modal-error");
        error.empty();
        error.append(msg);
      }
    });
  });

    // Clears the modal when it is hidden
  $('#login-modal').on('hide.bs.modal', function () {
    $("#username").select2('val', '');
    $("#password").val('');
    $(".login-modal-error").empty();
  });

  // Creates the selector in the login modal
  $('.user-selector').select2({
    width:"100%",
    placeholder: "Select User",
    allowClear: true,
  });  

  /********************************************************************************
	 * Admin view functions
	 ********************************************************************************/

  // Handles the user selection in the Admin view
  $("#user-select").on('select2:select', function(){
  	var linuxName = $("#user-select").val();
  	var student = myData['students'][linuxName];
    $("#new-name").val(student['realName']);
    $("#new-linux").val(student['username']);
    $("#update-admin-checkbox").prop("checked", student['isAdmin']);
  });

  // Handles the unselection of a user in the Admin view
  $("#user-select").on('select2:unselect', function(){
  	$("#new-linux").val('');
  	$("#new-name").val('');
  	$("#update-admin-checkbox").prop("checked", false);
  });

  // Project dropdown creation in Admin view
  $("#project-dropdown").select2({
    width:"100%",
    placeholder: "Select Project",
    allowClear: true
  });

  $("#project-dropdown").on('select2:select', function(){
		var projIdx = $(this).val();
		var project = myData['projects'][projIdx];
		$projectName = $("#project-dropdown").val();
		console.log(project);
		switch(project['status']){
			case 'closed':
				$("#close-radio").prop("checked", true);
				break;
			case 'open':
				$("#open-radio").prop("checked", true);
				break;
			default:
				break;
		}
		
	});

  //
  $("#user-select").select2({
    width:"100%",
    placeholder: "Select User",
    allowClear: true
  });

  $("#team-project-dropdown").select2({
    width:"100%",
    placeholder: "Select Project",
    allowClear: true
  });


  $("#team-select").select2({
    width:"100%",
    placeholder: "Select User",
    allowClear: true
  });
  
  $(".draggable").on('touchmove', function(e) {
    var touches = e.originalEvent.changedTouches[0];
    $(e.currentTarget).css('left', touches.pageX - 25 + 'px');
    $(e.currentTarget).css('top', touches.pageY - 25 + 'px');
    e.preventDefault();
  });

  $("#team-project-dropdown").change( function () {
    var teamdivID = makeTeamDiv();
    var projectName = $(this).val();
    var teams = myData.teams[projectName];
    for (var i = 0; i < teams.length; i++) {
      for (var j = 0; j < teams[i].length; j++) {
        $("#"+teamdivID).append("<div ondragstart='drag(event)' draggable='true' class='student draggable' id='$linux_user'><b>"+teams[i][j]+"</b></div>");
      }
    }
  });
});



function addOneStudentPerTeam() {
  var students = $("#team-select-div").find('.student');
  $.each(students, function(index, student) {
    var divName = makeTeamDiv($(student).attr('id'));
    $(student).appendTo("#"+divName+" .panel-body");
  });
}

function deleteTeam(e) {
  var teamDiv = $(e.target).closest('.team-box');
  var members = $(teamDiv).find('.student');
  var teamnum = $(teamDiv).data('teamnum');

  for (var i = 0; i < members.length + 1; i++) {
    $(members[i]).appendTo('#team-select-div');
  }

  decrementTeamNums(teamnum);
  teamDiv.remove();
}

function decrementTeamNums(teamnum) {
  var teams = $("#team-area").find('.team-box');
  var numteams = $("#team-area").data("numteams");

  for (var i = 0; i < numteams; i++) {
    if ($(teams[i]).data('teamnum') > teamnum) {
      $(teams[i]).data('teamnum', $(teams[i]).data('teamnum') - 1);
      renameTeam(teams[i]);
    }
  }

  $("#team-area").data("numteams", $("#team-area").data("numteams") - 1);
}

function renameTeam(team) {
  $(team).find('#team-name').text("Team " + $(team).data('teamnum'));
}

function makeTeamDiv() {
  var numTeams = $("#team-area").data("numteams") + 1;

  var $str = "<div class='panel panel-default team-box' data-teamnum='"+numTeams+"' id='team"+numTeams+"'>"+
            "<div class='panel-heading'>"+
            "<b id='team-name'>Team "+numTeams+"</b>"+
            "<button style='float:right' onclick='deleteTeam(event)'>Remove</button>"+
            "</div>"+
            "<div class='panel-body droppable' ondrop='drop(event)' ondragover='allowDrop(event)'>"+
            "</div>"+
            "</div>";

  $("#team-area").append($str);

  $("#team-area").data("numteams", numTeams);

  return "team" + numTeams;
}


function addUser(e) {
  e.preventDefault();

  // Gets the new linux username, real name, and admin status from the form
  var linux_user = $("#add-linux").val();
  var name = $("#add-user").val();
  var admin = $("#add-admin-checkbox").prop("checked");
  console.log(admin);
  var	pwHash = Sha256.hash("password");
  // If there are legitimate values, send the request
  if(linux_user != '' && name != ''){
  	$.post("./", {action:"CREATE_STUDENT", username:linux_user, realName:name, pwHash:pwHash, admin:admin}, function(data){
  		// If the request was successful update the page
  		if(JSON.parse(JSON.parse(data)['CREATE_STUDENT']) == true){
  			myData['students'].push({isAdmin:admin, pwHash:pwHash, realName:name, username:linux_user});
  			// Insert the new user into the selector
  			$("#user-select").append('<option value="' + (myData['students'].length-1) + '">' + name + '</option>');
  			// Update the select2 selector
  			initSelect2("#user-select");

  			$("#add-linux").val('');
  			$("#add-user").val('');

  			displayNotification("add-user-notify", "Successfully added <b>" + name + "<b>", "success");
  		}
  	});
  }
}

function saveProject(){
		switch($('input[name="project-open"]:checked').val()){
			case 'open':
				projectName = $("#project-dropdown").val();
				$.post('./', {action:"OPEN_PROJECT", project:projectName}, function(data){
					if(JSON.parse(JSON.parse(data)['OPEN_PROJECT']) == true){
						myData['projects'][projectName]['status'] = 'open';
					}
				});
				break;
			case 'close':
				projectName = $("#project-dropdown").val();
				$.post('./', {action:"CLOSE_PROJECT", project:projectName}, function(data){
					if(JSON.parse(JSON.parse(data)['CLOSE_PROJECT']) == true){
						myData['projects'][projectName]['status'] = 'closed';
					}
				});
				break;
			default:

				break;
		}
	}

function deleteUser(e){
	if($("#user-select").val() != ''){
		var username = $("#new-linux").val();
		var realName = $("#new-name").val();
		$.post('./', {action:"DESTROY_STUDENT", username:username}, function(data){
			if(JSON.parse(JSON.parse(data)['DESTROY_STUDENT']) == true){
				$("#new-linux").val('');
				$("#new-name").val('');
				var option = $("#user-select option:selected");
				option.remove();
				initSelect2("#user-select");
				$("#update-admin-checkbox").prop("checked", false);
				displayNotification("user-mod-notify", "Succesfully deleted <b>" + realName + "</b>", "success");
			}
		});
	}
	
}

function displayNotification(insertLocationID, message, type) {
  var alert = '<div class="alert alert-'+type+'" role="alert">' + message + '</div>'

  $("#"+insertLocationID).append(alert);

  setTimeout(function(){
    $("#" + insertLocationID).empty();
  }, 2000);
}

function initSelect2(selector){
	var sel2 = $(selector);
	sel2.select2("destroy");
	sel2.select2({width:"100%",
		placeholder: "Select User",
		allowClear: true});
}

function updateUser(e){
	if($("#user-select").val() != ''){
		var newLinux = $("#new-linux");
		var newName = $("#new-name");
		var username = newLinux.val();
		var realName = newName.val();
		var admin = $("#update-admin-checkbox").prop("checked");
		var primarykey = myData['students'][$("#user-select").val()]['username'];
		$.post('./', {action:"UPDATE_STUDENT", username:username, realName:realName, admin:admin, primarykey:primarykey}, function(data){
			if(JSON.parse(JSON.parse(data)['UPDATE_STUDENT']) == true){
				var studentIdx = $("#user-select").val();
				var student = myData['students'][studentIdx];
				student['username'] = username;
				student['realName'] = realName;
				student['isAdmin'] = admin;

				newLinux.val(username);
				newName.val(realName);
				$("#user-select option:selected").text(realName);
				initSelect2("#user-select");
				displayNotification("user-mod-notify", "Succesfully updated <b>" + realName + "</b>", "success");
			}
		});
	}
}

function resetPassword(){
	if($("#user-select").val() != ''){
		$.post('./', {action:"RESET_PASSWORD", username:$("#new-linux").val(), pwHash:Sha256.hash('password')}, function(data){
			if(JSON.parse(JSON.parse(data)['RESET_PASSWORD']) == true){
				
			}
		});
	}
}

function clearTeams() {
  $('.team-box').each( function () {
    var members = $(this).find('.student');
    var teamnum = $(this).data('teamnum');

    for (var i = 0; i < members.length + 1; i++) {
      $(members[i]).appendTo('#team-select-div');
    }

    decrementTeamNums(teamnum);
    this.remove();
  });
}

function saveTeams(){
	var project = $("#team-project-dropdown").val();
	console.log(project);
	if(project != ''){
		$(".team-box").each(function(tbIdx){
			members = [];
			$(this).find(".student").each(function(studIdx){
				members.push($(this).attr('id'));
			});
			console.log(JSON.stringify(members));
			$.post('./', {action:"CREATE_TEAM", team:JSON.stringify({project:project, members:members})}, function(data){

			});
			members = null;
		});
	}
}

/********************************************************************************
* Voting functions
********************************************************************************/

function allowDrop(e) {
  e.preventDefault();
}

function drag(e) {
  e.dataTransfer.setData("text", e.target.id);
  if ($("#"+e.target.id).closest('.vote-area') != null) {
    $("#"+e.target.id).closest('.vote-area').addClass('droppable');
  }
}

function drop(e) {
  e.preventDefault();

  var data = e.dataTransfer.getData("text");

  var droppable = e.target.closest(".droppable");

  $(droppable).append(document.getElementById(data));

  if ($(droppable).hasClass('vote-area')) {
    $(droppable).removeClass('droppable');
  }
}
