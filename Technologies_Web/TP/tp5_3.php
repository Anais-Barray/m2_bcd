<?php

	include('tp5_library.php');
	$temps = $_REQUEST["temps"];
	$vent = $_REQUEST["vent"];
	$temperature = $_REQUEST["temperature"];
	$date = $_REQUEST["date"];
	$auteur = $_REQUEST["auteur"];
	
	write_obs(array("temps"=> $temps, "vent"=>$vent, "temperature"=>$temperature, "date"=>$date, "auteur"=>$auteur));
	$data = read_data();
	echo "moyenne des temperatures : ".compute_mean_temperature($data["observations"])."<br><br>";


?>
