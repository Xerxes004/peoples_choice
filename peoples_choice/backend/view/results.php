
<h1 style="text-align: center">Votes for <?php echo $_GET['proj']; ?></h1>
<div class="ct-chart well"></div>



<div id="new-char" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

<script>
	var votesObject = null;

	function castBallot() {
		votesObject.first = $("#first-pick").find('.team').attr('id');
		votesObject.second = $("#second-pick").find('.team').attr('id');
		votesObject.third = $("#third-pick").find('.team').attr('id');
		votesObject.voter = "<?php echo $_SESSION['linux-name'] ?>";
	}

	$(function () {
    $('#new-char').highcharts({
        <?php echo $data['highcharts'] ?>
    });
});
</script>

<!-- vote section -->

<div class="panel panel-default">
	<div class="panel-body">
		
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
				<div class="droppable" ondrop="drop(event)" ondragover="allowDrop(event)">
					<div id="teamID1" class="team draggable" draggable="true" ondragstart="drag(event)"><b>Wesley Kelly,<br />Joel Sabol</b></div>
					<div id="teamID2" class="team draggable" draggable="true" ondragstart="drag(event)"><b>Dr. Gallagher,<br />Dr. Shomper</b></div>
					<div id="teamID3" class="team draggable" draggable="true" ondragstart="drag(event)"><b>Ernie,<br />Bert</b></div>
					<div id="teamID4" class="team draggable" draggable="true" ondragstart="drag(event)"><b>Hi Mom</b></div>
				</div>
				<div class="form-group">
				  <label for="write-in">Write In Vote:</label>
				  <input type="text" class="form-control" id="write-in">
				</div>
				<button>Add Write-in</button>
			</div>
		</div>

		<button onclick="castBallot()">Cast Ballot</button>
	</div>
</div>