
<h1 style="text-align: center">Votes for <?php echo $_GET['proj']; ?></h1>
<div class="ct-chart well"></div>

<script>
	$(document).ready(function () {
		var bar = new Chartist.Bar('.ct-chart', <?php echo $data['json']; ?>);
		bar.update();
	});
</script>

<div>

</div>