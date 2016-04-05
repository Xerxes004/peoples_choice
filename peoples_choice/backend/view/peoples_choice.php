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
              $first_place_array = $data['grades'][$proj->name]['first'];
              $second_place = $data['grades'][$proj->name]['second'];
              $third_place = $data['grades'][$proj->name]['third'];
              
              if (in_array($realName, $first_place_array)) {
                echo "<td class='score first-place'><b>1</b></td>";
              } else if (in_array($realName, $second_place)) {
                echo "<td class='score second-place'><b>2</b></td>";
              } else if (in_array($realName, $third_place)) {
                echo "<td class='score third-place'><b>3</b></td>";
              } else {
                echo '<td></td>';
              }
              
            }
            echo '</tr>';
          } 
        ?>
      </tbody>
    </table>
  </div>
</div>