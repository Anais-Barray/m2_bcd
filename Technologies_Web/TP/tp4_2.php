<?php

session_start();

$destinataire = $_REQUEST["dest"];
$nom = $_REQUEST["name"];
$objet = $_REQUEST["objet"];
$message = $_REQUEST["corps"];
$ok = mail($destinataire, $objet, $message);

if ((!$destinataire) || (!$objet) || (!$message) || (!$nom)) {

	header('Refresh:3; url=http://localhost/~abarray/php-test/tp4_1.php?name='.$nom.'&objet='.$objet);
	echo "Please fill all the fields";
	echo "<br><br>...Refreshing...";
	exit;
	
}



if ($ok) {
 	echo "message envoye";
} else {
	
	echo ">>>Erreur d'envoi de la requete ou l'Universite de Montpellier bloque votre envoi<<<";	
	echo "<br><br><br>resume de la requete : ";
	echo "<br><br>destinataire : " .$destinataire;
	echo "<br>objet : ".$objet;
	echo "<br>message : ".$message;
	
	if (!isset($_SESSION["compteur_essai"])) {
    		$_SESSION["compteur_essai"]=1;
	} else {
		$_SESSION["compteur_essai"]+=1;
	}	
	
	if (($_SESSION["compteur_essai"])<5){
		echo "<br><br><br>Il vous reste ".(5-$_SESSION["compteur_essai"])." essais";
	} else {
		echo "<br><br><br>Vous avez effectue plus de 5 tentatives.<br>Reset du compteur d'essai";
		unset($_SESSION["compteur_essai"]);
	}
	
}

?>
