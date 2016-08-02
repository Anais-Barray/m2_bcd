<?php
    header('Content-Type: application/json');

    // ouvrir la bdd
    include ('bdd.php');
    $base = connexionbd();
	
	//Recherche dans la BDD d'un motif passe en entree au script
    $mot = $_REQUEST["motif"];
    $req = 'select * from mangas where ';

    $req .= 'id LIKE "%'.$mot.'%" OR ';
    $req .= 'nom LIKE "%'.$mot.'%" OR ';
    $req .= 'type LIKE "%'.$mot.'%" OR ';
    $req .= 'latitude LIKE "%'.$mot.'%" OR ';
    $req .= 'longitude LIKE "%'.$mot.'%" OR ';
    $req .= 'horaires LIKE "%'.$mot.'%" OR ';
    $req .= 'date_recensement LIKE "%'.$mot.'%" OR ';
    $req .= 'photo LIKE "%'.$mot.'%" OR ';
    $req .= 'nom_participant LIKE "%'.$mot.'%" OR ';
    $req .= 'prenom_participant LIKE "%'.$mot.'%" OR ';
    $req .= 'commentaire LIKE "%'.$mot.'%";';

	//Renvoi les resultats de la requete
    $data = requete($base, $req);
    echo json_encode($data);

?>
