<?php
    session_start();
    include ('bdd.php');
    $base=connexionbd();
	
	//Connexion d'un utilisateur via un formulaire contenant le username et le passwd. S'ils sont corrects, la connexion est etablie.
    //TESTER SI LES CHAMPS SONT REMPLIS. Sinon envoie de message d'erreur en fonction du champ manquant.
    //TESTER SI LES CHAMPS REMPLIS SONT CORRECTS. Sinon envoie de message d'erreur.
    
    //Test du username
	if ((isset($_REQUEST["username"])) && ($_REQUEST["username"]!=null)){ //avec isset, si pas d'input, username vaut null, à tester aussi car on veut afficher un msg d'erreur si l'utilisateur n'a pas mis de username.
		$username=$_REQUEST["username"];
		
		//Test du pwd
		 if ((isset($_REQUEST["passwd"])) && ($_REQUEST["passwd"]!=null)){ //idem avec le pwd
			$pwd=hash("sha512",$_REQUEST["passwd"]);

			$req='SELECT * FROM users WHERE username="'.$username.'" AND pwd="'. $pwd .'";';
		    $data = requete($base, $req);
			
			//Test de la validite dans la BDD
		    if ($data) {
		        $_SESSION['username']=$username;
		        $table_msg["status"]="success";
		        
		    } else {
				$table_msg["status"]="error";
				$table_msg["message"]="Utilisateur ou mot de passe incorrect";
			}
			
		} else {
				$table_msg["status"]="error";
				$table_msg["message"]="Veuillez rentrer un mot de passe";
		}
		
	} else {
			$table_msg["status"]="error";
			$table_msg["message"]="Veuillez rentrer un utilisateur";
	}	
		
	//Renvoie un tableau contenant le statut (error/success) et un message s'il y a eu une error.
	echo JSON_encode($table_msg);
	
?>
