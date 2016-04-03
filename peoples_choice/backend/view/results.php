
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
		
		<div class="row">
			<div class="col-sm-4">
				<div class=" panel panel-default">
					<div class="panel-heading first"><b>First</b></div>
					<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class=" panel panel-default">
					<div class="panel-heading second"><b>Second</b></div>
					<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class=" panel panel-default">
					<div class="panel-heading third"><b>Third</b></div>
					<div class="panel-body droppable vote-area" ondrop="drop(event)" ondragover="allowDrop(event)">
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Teams</div>
			<div class="panel-body droppable" ondrop="drop(event)" ondragover="allowDrop(event)">
				<div id="teamID1" class="team draggable" draggable="true" ondragstart="drag(event)">Wesley Kelly,<br />Joel Sabol</div>
				<div id="teamID2" class="team draggable" draggable="true" ondragstart="drag(event)">Dr. Gallagher,<br />Dr. Shomper</div>
				<div id="teamID3" class="team draggable" draggable="true" ondragstart="drag(event)">Ernie,<br />Bert</div>
				<div id="teamID4" class="team draggable" draggable="true" ondragstart="drag(event)">Hi Mom</div>
			</div>
		</div>

		<button>Cast Ballot</button>
	</div>
</div>