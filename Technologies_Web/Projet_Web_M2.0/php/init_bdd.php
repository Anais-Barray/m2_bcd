<?php
	include ('bdd.php');
	
	//Initialisation de la BDD. Requiert d'avoir cree au prealable la database mangas.
	vidage_table();
	creation_table();
	insertion_exemples();
	$base = connexionbd();
	$req='select * from mangas';
	$data = requete($base, $req);
    //var_dump ($data);
?>
