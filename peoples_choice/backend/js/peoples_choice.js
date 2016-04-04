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

  $("#project-dropdown").change( function(){
		console.log("selected");
		console.log($('input[name="project-open"]:checked').val());
	});

  //
  $("#user-select").select2({
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
});



function addOneStudentPerTeam() {
  var students = $("#team-select").find('.student');
  $.each(students, function(index, student) {
    var divName = makeTeamDiv($(student).attr('id'));
    $(student).appendTo("#"+divName+" .panel-body");
  });
}

function makeTeamDiv(teamName) {
  var numTeams = $("#team-area").data("numteams") + 1;

  var str = "<div class='panel panel-default team' id='"+teamName+"team'>"+
            "<div class='panel-heading'>"+
            "<b>Team "+numTeams+"</b>"+
            "</div>"+
            "<div class='panel-body droppable' ondrop='dropTeam(event)' ondragover='allowDrop(event)'>"+
            "</div>"+
            "</div>";

  $("#team-area").append(str);

  $("#team-area").data("numteams", numTeams);

  return teamName + "team";
}


function addUser(e) {
  e.preventDefault();

  // Gets the new linux username, real name, and admin status from the form
  var linux_user = $("#add-linux").val();
  var name = $("#add-user").val();
  var admin = $("#add-admin-checkbox").prop("checked");
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

  			// Display the success notification for 2s
			  $("#user-added").removeClass("hide");
			  $("#user-added>#msg").html(
			    "<strong>Success!</strong> " +
			    name + " was successfully added to the system."
			    );
			  	setTimeout(function(){
			  		$("#user-added").addClass("hide");
			  	}, 2000);
  		}
  	});
  }
}

function deleteUser(e){
	if($("#user-select").val() != ''){
		$.post('./', {action:"DESTROY_STUDENT", username:$("#new-linux").val()}, function(data){
			if(JSON.parse(JSON.parse(data)['DESTROY_STUDENT']) == true){
				$("#new-linux").val('');
				$("#new-name").val('');
				var option = $("#user-select option:selected");
				option.remove();
				initSelect2("#user-select");
				$("#update-admin-checkbox").prop("checked", false);
				displayNotification();
			}
		});
	}
	
}

function displayNotification(){
	$("#user-updated").removeClass("hide");
	  $("#user-updated>#update-msg").html(
	    "<strong>Success!</strong> " +
	    name + " was successfully updated in the system."
	    );
	  	setTimeout(function(){
	  		$("#user-updated").addClass("hide");
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
			console.log(data, $.parseJSON("true"));
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
				displayNotification();
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

function dropTeam(e) {
  drop(e);
  var panelID = e.target.closest('.panel').id;
  var studentID = e.dataTransfer.getData("text");
  if (panelID === 'new') {
    e.target.closest('.panel').id = studentID +"team";    
  } else {
    e.target.closest('.panel').id += ":"+studentID+"team";
  } 
}
