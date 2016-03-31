<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="../model/js/sha256.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			document.getElementById('output').innerHTML = Sha256.hash('abc');
		});
	</script>
</head>
<body>
<p id="output"></p>
</body>
</html>