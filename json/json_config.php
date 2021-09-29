<?php

/*** FICHIER DE CONFIGURATION ET ENCODADE DU JSON ***/


echo "Début du Fichier JSON_CONFIG \n";

//print_r($listproducts);
//var_dump($listproducts);

// ENCODAGE DE LA VARIABLE EN JSON
$jso = json_encode($listproducts, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

// Affichage des erreurs liéé à l'encodage JSONs
echo "ERREUR JSON ENCODAGE : ".json_last_error_msg()."\n";

//var_dump($jso);

echo "Fin du fichier JSON_CONFIG \n";

require('json_file.php');

?>