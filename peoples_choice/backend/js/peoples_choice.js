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

  var myData = getUsers();

  $('.user-selector').select2({
    width:"100%",
    placeholder: "Select User",
    allowClear: true,
    data:myData
  });
  
  $('#login-modal').on('hide.bs.modal', function () {
    $("#username").select2('val', '');
    $("#password").val('');
    $(".login-modal-error").empty();
  });

});