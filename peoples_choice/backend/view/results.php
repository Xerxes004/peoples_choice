
<h1 style="text-align: center">Votes for <?php echo $_GET['proj']; ?></h1>
<div class="ct-chart well"></div>

<script>
	$(document).ready(function () {
		var bar = new Chartist.Bar('.ct-chart', <?php echo $data['json']; ?>);
		bar.update();
	});
</script>

<!-- vote section -->

<div class="panel panel-default">
	<div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"><h2>Teams</h2></div>
			<div class="panel-body droppable" ondrop="drop(event)" ondragover="allowDrop(event)">
				<div id="teamID1" class="team" draggable="true" ondragstart="drag(event)">team1</div>
				<div id="teamID2" class="team" draggable="true" ondragstart="drag(event)">team2</div>
				<div id="teamID3" class="team" draggable="true" ondragstart="drag(event)">team3</div>
				<div id="teamID4" class="team" draggable="true" ondragstart="drag(event)">team4</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class=" panel panel-default">
					<div class="panel-heading">First</div>
					<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class=" panel panel-default">
					<div class="panel-heading">Second</div>
					<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class=" panel panel-default">
					<div class="panel-heading">Third</div>
					<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>