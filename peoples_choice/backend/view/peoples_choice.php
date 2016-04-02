<div class="container">
  <div class="row">
    <div class="col-sm-1">
      
    </div>
    <div class="col-sm-10 table-responsive well">
      <table class="table table-hover">
        <thead class="thead-inverse">
          <tr>
            <?php 
              echo "<th></th>";
              $projs = $data['projects'];
              foreach ($projs as $proj) {
                echo "<th><a href='?proj=$proj->name&page=project_results'>$proj->name</a></th>";
              }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php 
            $users = $data["students"];
            foreach ($users as $user) {
              $username = $user->username;
              $realName = $user->realName;
              echo "<tr><td scope='row'><a href='http://judah.cedarville.edu/~$username/cs4220.html'>$realName</a></td>";
              foreach ($projs as $proj) {
                echo "<td>score</td>";
              }
              echo '</tr>';
            } 
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-sm-1">
      
    </div>
  </div>
  
</div>