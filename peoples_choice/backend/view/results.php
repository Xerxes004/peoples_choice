
<h1 style="text-align: center">Votes for <?php echo $_GET['proj']; ?></h1>
<div class="ct-chart well"></div>

<script>
  var voterName = <?php echo '"'.$_SESSION['linux-name'].'"' ?>;
  var votesObject = {};

  	function addWriteIn() {
  		'<div class="panel panel-default">'+
  			'<div class="panel-body">'+

  			'</div>'+
  		'</div>';
  	}
  
	function castBallot() {
		votesObject['first'] = $("#first-pick .team").attr('id');
		votesObject['second'] = $("#second-pick .team").attr('id');
		votesObject['third'] = $("#third-pick .team").attr('id');
		votesObject['voter'] = voterName;
	}

	function checkBallot() {
		if ($("#first-pick .team").attr('id') != null &&
			$("#second-pick .team").attr('id') != null &&
			$("#third-pick .team").attr('id') != null) {

			castBallot();
		} else {
			displayNotification("invalid-vote", "<b>Error!</b> Must specify one team for each placing!", "danger");
		}
	}

	$(document).ready(function () {
		var bar = new Chartist.Bar('.ct-chart', <?php echo $data['json']; ?>);
		bar.update();
	});
</script>

<!-- vote section -->

<div class="<?php echo ($_SESSION['logged-in'] ? '' : 'hidden'); ?>">
	<div class="row voting-panel">
		<div id="first-pick" class="col-sm-4">
			<div class="panel">
				<div class="panel-heading first"><b>First</b></div>
				<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
				</div>
			</div>
		</div>

		<div id="second-pick" class="col-sm-4">
			<div class="panel">
				<div class="panel-heading second"><b>Second</b></div>
				<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
				</div>
			</div>
		</div>

		<div id="third-pick" class="col-sm-4">
			<div class="panel">
				<div class="panel-heading third"><b>Third</b></div>
				<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Teams</div>
		<div class="panel-body">
			<div style="min-height: 20px; width:100%" class="droppable" ondrop="drop(event)" ondragover="allowDrop(event)">
				<?php
					$teams = $data['teams'];
					foreach ($teams as $team)
					{
						if (!in_array($_SESSION['username'], $team->members)) {
							echo '<div ondragstart="drag(event)" id="'.$team->id.'" class="draggable team" draggable="true"><b>';
							foreach ($team->members as $member)
							{
								echo $member.'<br />';
							}
							echo '</b></div>';
						}
					}
				?>
			</div>
			<hr />
			<div class="form-group">
			  <h3>Write In Vote</h3>
			  <div class="form-group">
			    <label for="user-select">Select User:</label>
			    <select class="form-control" id="user-select">
			  	  <option></option>
			      <?php 
			    	foreach ($data['students'] as $key => $student) {
			    		$realName = $student->realName;	
			    		echo "<option value='$key'>$realName<option>";
			    	}
			       ?>
			    </select>
			  </div>
			  <label for="write-in">Write In:</label>
			  <input type="text" name="write-in" class="form-control" id="write-in-box">
			</div>

			<div id="write-in-area">
			</div>
			<button onclick="addWriteIn()">Add Write-in</button>
		</div>
	</div>
	<div id="invalid-vote"></div>
	<button onclick="checkBallot()">Cast Ballot</button>
</div>