<?php
try {
	// modifiez "votrelogin" et "votremotdepasse" pour accéder à votre base de données
    $bdd = new PDO('mysql:host=venus;dbname=votrelogin', 'votrelogin', 'votremotdepasse');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


$sql = 'CREATE TABLE msgs (ID int NOT NULL AUTO_INCREMENT, nom varchar(255), msg varchar(255), PRIMARY KEY (ID));';
$query = $bdd->query($sql);
var_dump($query);

?>
