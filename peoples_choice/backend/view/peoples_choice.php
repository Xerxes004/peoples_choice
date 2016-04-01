
    <!-- Login Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="loginmodal-container">
          <h1>Login</h1><br>
          <div class="login-modal-error"></div>
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
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#">People's Choice</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="login-button" data-toggle="modal" data-target="#login-modal"><?php echo$_SESSION['logged-in']? $_SESSION['username'] : '<span class="glyphicon glyphicon-log-in"></span> Log In' ?></a></li>
          </ul>
        </div>
      </div>
    </nav>


    <div class="container">
      <div class="row">
        <div class="col-sm-2">
          
        </div>
        <div class="col-sm-8 table-responsive">
          <table class="table table-hover">
            <thead class="thead-inverse">
              <tr>
                <?php 
                  echo "<th></th>";
                  $projs = $data['projects'];
                  foreach ($projs as $proj) {
                    echo "<th>$proj</th>";
                  }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php 
                $users = $data["users"];
                foreach ($users as $user) {
                  echo "<tr><td scope='row'>$user</td>";
                  foreach ($projs as $proj) {
                    echo "<td>score</td>";
                  }
                  echo '</tr>';
                } 
              ?>
            </tbody>
          </table>
        </div>
        <div class="col-sm-2">
          
        </div>
      </div>
      
    </div>