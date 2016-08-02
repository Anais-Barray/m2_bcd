<?php
    session_start();
    //ouvrir la bdd
    include ('bdd.php');
    $base = connexionbd();
    
    //suppression d'une entree de la bdd en fonction de l'ID correspondante donnee en entree au script. Possible que si l'utilisateur est connecte.
    if ($_SESSION["username"] != null) {
        $strreq = "delete from mangas where id='".$_REQUEST['dataId']."'";
        $req = $base->prepare($strreq);
        $req-> execute();
    }
?>
