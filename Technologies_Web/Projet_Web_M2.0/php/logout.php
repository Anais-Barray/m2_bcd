<?php
    session_start();
	
	//Deconnecter l'utilisateur courant.
    unset ($_SESSION["username"]);
?>
