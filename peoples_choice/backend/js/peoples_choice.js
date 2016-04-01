$(document).ready(function(){
  $("#login-submit-button").click(function(evt){
    
  });

  $('#login-modal').on('shown.bs.modal', function () {
    $('#username').focus();
  })

  $("#login-form").submit(function(evt){
    evt.preventDefault();

    var uname = $("#username").val();
    var pass = $("#password").val();
    
    $.post('index.php',{username:uname, password:pass}, function(data){
      var result = JSON.parse(data);
      if(result['login'] == true){
        $(".login-button").text(result['user']);
        $(".jumbotron").append('<p>Login Success</p>');
        $("#login-modal").modal('hide');
      }else{
        var msg = '<div class="alert alert-danger" role="alert">Name and Password do not match</div>';
        $(".login-modal-error").empty();
        $(".login-modal-error").append(msg);
      }
    });
  });
  
  $('#login-modal').on('hide.bs.modal', function () {
    $("#username").val('');
    $("#password").val('');
    $(".login-modal-error").empty();
  });
});