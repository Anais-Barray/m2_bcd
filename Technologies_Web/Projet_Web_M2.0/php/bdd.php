<?php

// cette fonction vous connecte à la base de données et retourne
// un objet grâce auquel vous allez effectuer des requêtes SQL
function connexionbd() {

	// A MODIFIER : spécifiez votre login et votre mot de passe ici
	$username = "root";
	$password = "yakitate!!";
	$dbname = "mangas";
    
	// chaîne de connexion pour PDO (ne pas modifier)
	//$dsn = "mysql:host=venus;dbname=$dbname";
    $dsn = "mysql:dbname=$dbname";

	// connexion au serveur de bases de données
	$bd = new PDO($dsn, $username, $password);
	
	return $bd;
}

// cette fonction effectue une requête SQL. On doit lui fournir
// l'objet base de données et la requête
function requete($bd, $req) {

	// appel de la méthode query() sur l'objet base de données :
	// la requête est traitée par le serveur et retourne un pointeur de resultat
	$resultat = $bd->query($req);

	// on demande à ce pointeur d'aller chercher toutes les données de résultat
	// d'un coup - on obtient un tableau de tableaux associatifs (un par ligne de la table)
	// Note : dans le cas d'une insertion, on ne récupère pas le resultat
	if ($resultat) {
		$tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);	
		// on retourne ce tableau
		return $tableau;
	}
}

// cree la table qui stockera les lieux d'interêt touristique
function creation_table() {
	$maBd = connexionbd();
	$maRequeteCreation = "CREATE TABLE mangas (id integer AUTO_INCREMENT, nom varchar(100), type varchar(50), latitude float, "
        . "longitude float, horaires varchar(10), date_recensement date, photo varchar(255), nom_participant varchar(50), "
        . "prenom_participant varchar(50), commentaire text, PRIMARY KEY(id)) CHARACTER SET UTF8;"
        . "CREATE TABLE users (id integer AUTO_INCREMENT, username varchar(20), pwd varchar(255), PRIMARY KEY(id)) CHARACTER SET UTF8;";
	
    $monResultat = requete($maBd, $maRequeteCreation);
    
}

// insère des données d'exemple dans la base
function insertion_exemples() {
	$maBd = connexionbd();
	$maRequeteInsertion = "INSERT INTO mangas VALUES "
		. "(DEFAULT, 'IKOKU', 'Mangas', 43.6085632, 3.8805144, '19h', '2015-10-24', 'http://www.ikoku.org/images/stories/boutik.jpg', 'Petitjean', 'Paul', 'Fermeture programmée'),"
		. "(DEFAULT, 'JINJA Manga', 'Mangas', 43.607677, 3.876089, '21h30', '2015-10-19', 'http://www.nautiljon.com/images/boutiques/00/49/1353661113221.jpg', 'Durand', 'Jean', 'Espace détente de 130m² dédié à la lecture de manga'),"
		. "(DEFAULT, 'PLANÈTES INTERDITES', 'BD-Mangas', 43.603156, 3.918596, '19h', '2010-09-17', 'http://www.lr2l.fr/sites/default/files/imagecache/ric_grand/upload/media_ric/01_libplanetesinterdites.jpg', 'Martinez', 'Martine', 'toto'),"
		. "(DEFAULT, 'Album', 'BD-Mangas', 43.614291, 3.872971, '19h', '2014-10-11', 'http://www.toutmontpellier.fr/photos/7/1/1/1/11177/very_large_11177_2586_album-montpellier.jpg', 'Flahault', 'Charlotte', 'Jy vais souvent avec mon amie Jeanne'),"
		. "(DEFAULT, 'Azimuts', 'BD-Mangas', 43.6117279,3.8794238, '19h', '1998-02-04', 'http://esphoto980x880noname.mnstatic.com/e03a7bf66c96553f2e95d919f37bbdb0', 'Day', 'Kelly', '16 000 titres d\'albums BD, comics et mangas en rayon');"
        . "INSERT INTO users VALUES (DEFAULT, 'Fred', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'), (DEFAULT, 'Anais', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2');";
	$monResultat = requete($maBd, $maRequeteInsertion);
		
}

// vide la table de toutes ses donnees
function vidage_table() {
	$maBd = connexionbd();
	$maRequeteVidage = "TRUNCATE TABLE mangas";
	$monResultat = requete($maBd, $maRequeteVidage);
}

?>
