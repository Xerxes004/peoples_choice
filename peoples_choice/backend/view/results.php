<div class="column">
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<h1 style="text-align: center">Votes for <?php echo $_GET['proj']; ?></h1>
			<div class="ct-chart well"></div>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
<script>
	$(document).ready(function () {
		var bar = new Chartist.Bar('.ct-chart', <?php echo $data; ?>);
		bar.update();
	});
</script>