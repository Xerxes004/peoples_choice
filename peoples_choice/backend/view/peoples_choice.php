<div class="panel panel-default">
  <div id="results-table" class="table-responsive panel-body">
    <table class="table table-hover">
      <thead class="thead-inverse">
        <tr>
          <?php 
            echo "<th></th>";
            $projs = $data['projects'];
            //print_r($projs);
            foreach ($projs as $proj) {
              echo "<th><a href='?proj=$proj->name&page=project_results'>$proj->name</a></th>";
            }
          ?>
        </tr>
      </thead>
      <tbody id="project-results">
        <?php 
          $users = $data["students"];
          foreach ($users as $user) {
            $username = $user->username;
            $realName = $user->realName;
            echo "<tr><td scope='row' class='test'><a href='http://judah.cedarville.edu/~$username/cs4220.html'>$realName</a></td>";
            foreach ($projs as $proj) {
              echo "<td class='score first-place'><b>1</b></td>";
            }
            echo '</tr>';
          } 
        ?>
      </tbody>
    </table>
  </div>
</div>