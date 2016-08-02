<?php
//print_r($_REQUEST);

try {
    $bdd = new PDO('mysql:host=localhost;dbname=superchat', 'monty', 'python');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


// add message in db, on fait avec prepare et execute, evite que les pirates insertent des erreurs. Sinon on pourrait faire des inserts normaux/
$req = $bdd->prepare('INSERT INTO msgs(nom, msg) VALUES(:nom, :msg)');

$req->execute(array(
	'nom' => $_REQUEST['nom'],
	'msg' => $_REQUEST['msg'],
));

// redirect to index, a enlever car on veut juste une procedure distante.
//header('Location: ../index.php');
echo "ok";

?>
