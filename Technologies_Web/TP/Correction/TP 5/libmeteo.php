<?php
// Ceci est une bibliothèque de fonctions PHP. Elle ne doit contenir que des
// fonctions prédéfinies, prêtes à être utilisées.
// Pour utiliser cette bibliothèque dans une autre page PHP, incluez-la comme ceci :
// include('libmeteo.php');


/**
 * Cette fonction lit les données contenues dans le fichier .json, les décode
 * sous forme de tableau (array) PHP, et retourne ce tableau
 */
function lire_observations() {
	// On règle le chemin du fichier de données. C'est un chemin relatif (ici le fichier
	// doit se trouver dans le même dossier que cette bibliothèque sinon ça ne marchera pas)
	$chemin_fichier_donnees = 'donnees.json';

	// on lit le contenu du fichier : c'est une chaîne de caractères
	$contenu_fichier = file_get_contents($chemin_fichier_donnees);

	// DEBUG : pour vérifier que le contenu du fichier a bien été lu,
	// on peut utiliser var_dump(), qui doit nous afficher une "string" :
	// var_dump($contenu_fichier);

	// sachant que cette chaîne de caractères contient des données au format JSON,
	// on décode ces données pour obtenir un tableau (array) PHP
	$donnees = json_decode($contenu_fichier, true);

	// DEBUG : pour vérifier que le JSON a bien été décodé,
	// utilise à nouveau var_dump(), qui doit nous afficher un "array" :
	// var_dump($donnees);

	// on retourne ces données
	return $donnees;
}

/**
 * Cette fonction ajoute une donnée d'observation au fichier .json. Pour ce faire, elle
 * décode entrièrement le fichier pour obtenir un tableau PHP, ajoute une donnée à ce
 * tableau, encode ce tableau enrichi au format JSON, puis réécrit entièrement le fichier
 */
function enregistrer_observation($donneeObservation) {
	// On règle le chemin du fichier de données pour écrire dedans
	$chemin_fichier_donnees = 'donnees.json';

	// on réutilise la fonction lire_observations() pour ne pas
	// réécrire le code correspondant
	$donnees = lire_observations();

	// on ajoute au tableau la donnée d'observation passée en paramètre
	$donnees['observations'][] = $donneeObservation;

	// on réencode le tableau en JSON
	$donnees_encodees = json_encode($donnees);

	// on écrit ces données dans le fichier pour le mettre à jour
	file_put_contents($chemin_fichier_donnees, $donnees_encodees);
}

/**
 * Cette fonction lit les données contenues dans le fichier .json, et
 * calcule la moyenne de température et de vent sur l'ensemble des données;
 * elle retourne ces deux moyennes dans un tableau. ATTENTION, vous devez
 * donner à Apache les droits d'écriture sur ce fichier !
 */
function calculer_statistiques() {
	// on réutilise la fonction lire_observations() pour ne pas
	// réécrire le code correspondant
	$donnees = lire_observations();

	// dans les données lues, on va chercher la clé "observations" : c'est là que sont listées les obs.
	$observations = $donnees['observations'];

	// on prépare les variables calculées, en les initialisant à 0
	$sommeTemp = 0;
	$sommeVent = 0;

	// on itère sur les données lues pour calculer les moyennes.
	// si $donnees est vide, foreach ne fera aucun tour de boucle
	foreach ($observations as $obs) {
		// à chaque tour, on additionne les valeurs de vent et de température de
		// l'observation en cours, en accédant aux bonnes clés du tableau
		$sommeTemp += $obs['temperature'];
		$sommeVent += $obs['vent'];
	}
	
	// calcul des moyennes
	$moyTemp = $sommeTemp / count($observations);
	$moyVent = $sommeVent / count($observations);

	// on retourne un tableau contenant deux paires de clés / valeurs
	return array(
		"moyenne_temp" => $moyTemp,
		"moyenne_vent" => $moyVent
	);
}

// RAPPEL : vous ne devez pas exécuter de code dans une bibliothèque. Le code
// ci-dessous est à des fins de débogage seulement !

// DEBUG : TEST de la fonction lire_observations()
// var_dump(lire_observations());

// DEBUG : TEST de la fonction enregistrer_observation()
/*enregistrer_observation(array(
	"temps" => "pluie",
	"vent" => 54,
	"temperature" => 7,
	"date" => "18/10/2015",
	"auteur" => "mathias"
));*/

// DEBUG : TEST de la fonction calculer_statistiques()
// var_dump(calculer_statistiques());

?>
