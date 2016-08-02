<?php
	// on inclut la bibliothèque "libmeteo" pour réutiliser les fonctions qu'on a préparées
	include('libmeteo.php');

	// DEBUG - on peut utiliser var_dump() pour voir rapidement les données envoyées
	// par le formulaire :
	// var_dump($_REQUEST);

	// on récupère les paramètres envoyés par le formulaire
	// NOTE : on ne fait ici aucune détection d'erreur du type if(isset($_REQUEST['date'])) { ...
	// en conditions réelles, il faut se protéger contre ce type d'erreurs
	$type = $_REQUEST['type'];
	$vent = $_REQUEST['vent'];
	$temperature = $_REQUEST['temperature'];
	$date = $_REQUEST['date'];
	$auteur = $_REQUEST['auteur'];

	// on ajoute la donnée au fichier .json en respectant le format défini dans celui-ci :
	// chaque donnée est un tableau avec les clés "type, vent, temperature, date, auteur".
	// La fonction enregistrer_observation() est disponible grâce à l' "include" ci-dessus
	enregistrer_observation(array(
		"temps" => $type,
		"vent" => $vent,
		"temperature" => $temperature,
		"date" => $date,
		"auteur" => $auteur
	));

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
	</head>
	<body>
		<p>
		<?php
			// dans la foulée, on affiche les statistiques, en tenant compte de la nouvelle donnée.
			$stats = calculer_statistiques();
			echo "La température moyenne est: " . $stats['moyenne_temp'] . "<br/>";
			echo "La vitesst moyenne du vent est: " . $stats['moyenne_vent'] . "<br/>";
		?>
			<a href="formulaire.html">Ajouter une autre observation</a>
		</p>
	</body>
</html>
