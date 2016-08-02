<?php
    // ouvrir la bdd
    include ('bdd.php');
    $base = connexionbd();

	//Ajout dans la BDD d'une entree dont les parametres sont passes au script via un formulaire
    $strreq = 'insert into mangas (id, nom,type,latitude,longitude,horaires,date_recensement,photo,nom_participant,prenom_participant,commentaire)';
    $strreq .= ' values (:id, :nom,:type,:latitude,:longitude,:horaires,:date_recensement,:photo,:nom_participant,:prenom_participant,:commentaire)';
    
    $req = $base->prepare($strreq);
    $req-> execute(array(
        'id' => 'DEFAULT',
        'nom' => $_REQUEST['nom'],
        'type' => $_REQUEST['type'],
        'latitude' => $_REQUEST['latitude'],
        'longitude' => $_REQUEST['longitude'],
        'horaires' => $_REQUEST['horaires'],
        'date_recensement' => $_REQUEST['date_recensement'],
        'photo' => $_REQUEST['photo'],
        'nom_participant' => $_REQUEST['nom_participant'],
        'prenom_participant' => $_REQUEST['prenom_participant'],
        'commentaire' => $_REQUEST['commentaire'],
    ));
?>
