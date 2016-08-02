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

		<h2>Aujourd'hui</h2>

		<?php
			$jourDeLaSemaine = date("w");
			echo "On est " . $messages[$jourDeLaSemaine];
		?>

		<h2>Tous les jours de la semaine</h2>

		<?php
			foreach ($messages as $jour) {
				echo '<a href="http://fr.wikipedia.org/wiki/' . $jour . '">' . $jour . '</a>';
				echo "<br/>";
			}

			// autre possibilité pour faire la boucle
			/*for ($i=0; $i < 7; $i++) {
				echo '<a href="http://fr.wikipedia.org/wiki/' . $messages[$i] . '">' . $messages[$i] . '</a>';
				echo "<br/>";
			}*/
		?>
	</body>
</html>
