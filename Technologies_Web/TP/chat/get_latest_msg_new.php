<?php



// return all messages
function get_messages() {

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=superchat', 'monty', 'python');
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $data = Array("msgs" => Array ()); 
    
    // query
    $query = $bdd->query('SELECT * FROM msgs ORDER BY ID DESC');
    while ($donnees = $query->fetch()) {
        $data['msgs'][] = Array('nom' => $donnees['nom'], 'msg' => $donnees['msg']);
    }
    return $data;
    
}    

$myvar = get_messages();
echo json_encode($myvar);

?>
