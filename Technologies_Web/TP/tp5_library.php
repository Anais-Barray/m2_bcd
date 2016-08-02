<?php

//read data from json file
function read_data(){
	$filename = 'bdd_meteo.json';
	$raw = file_get_contents($filename);
	$data = json_decode($raw,true);
	
	//si bdd vide, creation
	if (empty($data)) {
		$data = array("observations" => array());
	}
	
	return $data;

}


//write a weather obs to json file
//$obs : array("temps" => "sun", "vent" => 10, "temperature" => 15 ...)
function write_obs($obs){
	$filename = 'bdd_meteo.json';

	//lire ce qu'on avait avant, le garder en memoire, rajouter notre donnee a la fin, puis écrire dans fichier. Sinon on ecrase la bdd
	$ajout = true;
	
	$previous_data = read_data();
	$previous_data["observations"][] = $obs;		
	
	$json = json_encode($previous_data);
	if ($json == false) {
		$ajout=false;
		return $ajout;
	}
	
	$ajout=file_put_contents($filename,$json);
	
	//var_dump($ajout);
	return $ajout;
	
}


//calcule la moyenne des temperatures contenues dans la bdd json
function compute_mean_temperature($obs_array){

	$sum = 0;
	foreach($obs_array as $obs){
		$sum += $obs["temperature"];
	}

	$mean = ($sum / count($obs_array));
	
	return $mean;

}

//var_dump($mean); type variable et ce quelle contient, pratique pour debuguer.


?>
