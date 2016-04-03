$(document).ready(function(){
  $('#login-modal').on('shown.bs.modal', function () {
    $('#username').focus();
  });

  $("#user-logout").click(function(evt){
    $.post('index.php', {action:"LOGOUT"});
    $("#login-field").removeClass('hidden');
    $("#user-tab").addClass('hidden');
  });

  $("#login-form").submit(function(evt){
    evt.preventDefault();

    var uname = $("#username").val();
    var pass = Sha256.hash($("#password").val());
    console.log(pass);
    
    $.post('index.php',{action:"LOGIN", username:uname, password:pass}, function(data){
      var result = JSON.parse(data);
      if(result['login'] == true){
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

  $("#user-modification-form").submit(function(){

  });

  $("#user-select").change(function(evt){
    $("#new-name").val($("#user-select option:selected").text());
    $("#new-linux").val($("#user-select").val());
  });

  $("#project-dropdown").select2({
    width:"100%",
    placeholder: "Select Project",
    allowClear: true
  });

  $("#user-select").select2({
    width:"100%",
    placeholder: "Select User",
    allowClear: true
  });
  
  $('#login-modal').on('hide.bs.modal', function () {
    $("#username").select2('val', '');
    $("#password").val('');
    $(".login-modal-error").empty();
  });

  $('.user-selector').select2({
    width:"100%",
    placeholder: "Select User",
    allowClear: true,
  });  
});


function addUser(e) {
  e.preventDefault();

  var linux_user = $("#add-linux").val();
  var name = $("#add-user").val();
  var admin = $("#add-admin-checkbox").prop("checked");
  if(linux_user != '' && name != ''){
  	$.post("./", {action:"CREATE_STUDENT", username:linux_user, realName:name, pwHash:Sha256.hash("password"), admin:admin}, function(data){
  		if(JSON.parse(JSON.parse(data)['CREATE_STUDENT']) == true){
  			$("#user-select").append('<option value="' + linux_user + '">' + name + '</option>');
  			initSelect2("#user-select");
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
		var primarykey = $("#user-select").val();
		$.post('./', {action:"UPDATE_STUDENT", username:username, realName:realName, admin:admin, primarykey:primarykey}, function(data){
			console.log(data, $.parseJSON("true"));
			if(JSON.parse(JSON.parse(data)['UPDATE_STUDENT']) == true){
				newLinux.val(username);
				newName.val(realName);
				var option = $("#user-select option:selected");
				option.val(username);
				option.text(realName);
				initSelect2("#user-selector");
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

function allowDrop(e) {
  e.preventDefault();
}

function drag(e) {
  e.dataTransfer.setData("text", e.target.id);
}

function drop(e) {
  e.preventDefault();
  
  var data = e.dataTransfer.getData("text");

  $(e.target.closest(".droppable")).append(document.getElementById(data));
  
}
