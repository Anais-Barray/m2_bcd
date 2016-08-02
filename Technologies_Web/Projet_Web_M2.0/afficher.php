<?php
	include("html/head.html");

	//PAGE D'AFFICHAGE STATIQUE DE LA BDD
	
	// ouvrir la bdd
	include ('php/bdd.php');
	$base = connexionbd();
	$req='select * from mangas';
	$data = requete($base, $req);
	//Entêtes du tableau = clés d'un tableau associatif du tableau data:
	//id|nom|type|latitude|longitude|tarif|date_recensement|photo|nom_participant|prenom_participant|commentaire
	echo '	<div class="div_liste">';
	echo '
		<table class="table table-responsive bordered-table table-striped table-petit">
			<thead> 
				<tr>';
	$j=0;
    foreach($data[0] as $x => $x_value) {
        //"capit"><div class="col-' + j + '">'
        echo '<th class="capit"><div class="col-' . $j . '">'. str_replace("_", " ", $x) . '</div></th>';
        $j=$j+1;   
	}
	echo '</tr>
	</thead>
	<tbody>
	';
	//remplir le tableau : valeurs des tableaux associatifs du tableau data
	foreach($data as $ligne) {
		echo "<tr>";
		$j=0;
        foreach($ligne as $x => $x_value) {
			// on teste si c'est la colonne photo alors on affiche la photo et non l'adresse
			if ($x == 'photo') {
				echo '<td><div class="col-' . $j . '"><img src="'.$x_value.'" width="150px"/></div></td>';
			} else {
				echo '<td><div class="col-' . $j . '">'.$x_value.'</div></td>
				';
			}
            $j=$j+1;
		}
		echo "</tr>
		";
	}
	echo "</tbody>
	</table>";
	echo '</div>';
	
?>

<?php
	include("html/foot.html");
?>
