<!-- Login Modal tabindex="-1"-->
    <div class="modal fade" id="login-modal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="loginmodal-container">
          <h1>Login</h1><br>
          <div class="login-modal-error"></div>
          <select class="user-selector">
            <option></option>
          </select>
          <form id="login-form">
            <input type="text" name="user" id="username" placeholder="Username">
            <input type="password" name="pass" id="password" placeholder="Password">
            <input type="submit" name="login" class="login loginmodal-submit" id="login-submit-button" value="Login">
          </form>

          <div class="login-help">
          <a href="#">Forgot Password</a>
          </div>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">People's Choice</a>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          
        </div> <!-- navbar-header -->

        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://localhost/webapps/proj5/peoples_choice/">Home</a></li>
            <li><a href="#">Admin</a></li>
          </ul>
          <?php 
            $userVisible = $_SESSION['logged-in'] ? '':'hidden';
            $loginVisible = $_SESSION['logged-in'] ? 'hidden':'';
           ?>
          <ul class='nav navbar-nav navbar-right'>";
          
            <li class="dropdown">
            <?php echo "<a class='dropdown-toggle $userVisible' id='user-tab' data-toggle='dropdown' href='#'>".$_SESSION['username']; ?><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#" id="user-logout">Logout</a></li>
                <li><a href="#">My Results</a></li>
                <li><a href="#">My Votes</a></li> 
              </ul>
            </li>
            <!--<li><a href="#" class="hidden" id="user-tab">uname</a></li>-->
            <?php  echo "<li id='login-field' class='$loginVisible'>";?>
            <a href="#" id="login-button" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
          </ul>
        </div> <!-- navbar -->
      </div>
    </nav>