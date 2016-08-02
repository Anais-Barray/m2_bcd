<html>
<head>
	<title>premier tp PHP</title>
</head>
<body>
	
	<h1>Hello PHP</h1>
 	L'heure actuelle est :
 	<?php
 		echo date('Y-m-d H:i:s') . "<br/>";
 	?>
 	<br/>
 	
	Votre adresse IP est :
 	<?php
 		echo $_SERVER["REMOTE_ADDR"]."<br/><br/>";
 	?>
 	
	
	<br/>
 	<?php
  		$day=date("w");
 		$jours=array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");
		$nomJour=0;
		if ($_GET["jour"] == ""){
			$nomJour=$jours[$day];
		} else {
			$nomJour=$jours[$_GET["jour"]];
		}
		if ($_GET["jour"]>6){
			echo "Erreur : Preciser un chiffre entre 0 et 6 ! <br/>";
			$nomJour=$jours[$day];
		}
 	?>
 	
 	Aujourd'hui nous sommes : <?php echo $nomJour; ?>
	<a href="https://fr.wikipedia.org/wiki/<?php echo $nomJour;?>">Lien Wikipedia</a>
</body>
</html>
