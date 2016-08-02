<?php
// démarrage / reprise de la session
session_start();

// réinitialisation du compteur, s'il existe
if (isset($_SESSION['nb_emails'])) {
	$_SESSION['nb_emails'] = 0;
}
?>
