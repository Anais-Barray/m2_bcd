<?php
// démarrage / reprise de la session
session_start();

// initialisation du compteur d'emails dans la session, si ce n'est pas déjà fait
if (! isset($_SESSION['nb_emails'])) {
	$_SESSION['nb_emails'] = 0;
}

// test : l'utilisateur a-t-il épuisé son quota de 5 emails ?
if ($_SESSION['nb_emails'] >= 5) {
	echo 'Vous avez déjà envoyé vos 5 emails ! <a href="formulaire.html">RETOUR</a>';
	// IMPORTANT ! sortie du programme
	exit;
}

// vérification du formulaire : tous ls champs sont-ils bien remplis ?
if (empty($_REQUEST['destinataire']) || empty($_REQUEST['nom']) || empty($_REQUEST['objet']) || empty($_REQUEST['message'])) {
	// le formulaire n'a pas été correctement rempli : redirection

	//header('Location: formulaire.html'); // redirection immédiate, ou...
	header('Refresh: 2; url=formulaire.html'); // ...redirection après 2 secondes
	echo "Le formulaire n'était pas rempli correctement... redirection dans 2 secondes";
	exit;
}

// affichage de débogage des variables reçues :
//var_dump($_REQUEST);

// récupération des variables, de différentes façons équivalentes
$destinataire = $_REQUEST['destinataire'];
$nom = $_REQUEST['nom'];
$objet = $_REQUEST['objet'];
$format = $_REQUEST['format'];
$message = $_REQUEST['message'];

// envoi de l'email et récupération de la valeur de retour de la fonction mail()
$ok = mail($destinataire, $objet, $message);

// test de cette valeur de retour
if ($ok) {
	echo "Le message a bien été envoyé";
} else {
	echo "Erreur lors de l'envoi du message";
}
echo "<br/>";

// un email a été envoyé - ATTENTION ce code devrait se trouver dans le if ($ok) afin de
// ne comptabiliser l'envoi que s'il a réussi, mais le serveur nous interdisant d'envoyer
// les messages, on fait le décompte même en cas d'échec afin de montrer le mécanisme
$_SESSION['nb_emails']++;

// affichage du nombre d'emails envoyés
echo "Vous avez envoyé " . $_SESSION['nb_emails'] . " emails";

?>
