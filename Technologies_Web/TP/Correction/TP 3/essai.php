<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
			echo "La date est: " . date("Y/m/d h:i:s");
			echo "<br/>";
			echo "L'adresse IP du client est: " . $_SERVER['REMOTE_ADDR'];
		?>
	</body>
</html>
