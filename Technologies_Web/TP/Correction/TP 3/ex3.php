<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
			$messages = array(
				"dimanche",
				"lundi",
				"mardi",
				"mercredi",
				"jeudi",
				"vendredi",
				"samedi"
			);
		?>

		<h2>Jour choisi</h2>

		<?php
			// vérification de la présence du paramètre dans l'URL, et de sa validité
			if (isset($_GET['jour']) && is_numeric($_GET['jour']) && $_GET['jour'] >= 0 && $_GET['jour'] <= 6) {
				$jourDeLaSemaine = $_GET['jour'];
			} else {
				// valeur par défaut : mercredi
				$jourDeLaSemaine = 3;
			}
			echo "Le jour passé en paramètre est " . $messages[$jourDeLaSemaine];
		?>
	</body>
</html>
