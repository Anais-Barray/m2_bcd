<?php
//print_r($_REQUEST);

try {
    $bdd = new PDO('mysql:host=venus;dbname=votrelogin', 'votrelogin', 'votremotdepasse');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


// add message in db
$req = $bdd->prepare('INSERT INTO msgs(nom, msg) VALUES(:nom, :msg)');

$req->execute(array(
	'nom' => $_REQUEST['nom'],
	'msg' => $_REQUEST['msg'],
));

// redirect to index
header('Location: ../index.php');

?>
