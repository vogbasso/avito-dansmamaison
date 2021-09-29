<?php

/*** Ouverture du fichier JSON sur le serveur ***/ 

// JSON LOCAL AU FICHIER
$fichierJson = fopen("mamaison.json","w") or die("Impossible de trouver ce fichier");
fwrite($fichierJson,$jso);
fclose($fichierJson);



/*** définissez le chemin de la création du fichier JSON***/
// JSON SUR LE SERVEUR APACHE DANS LE DOSSIER HTML
$fichierJson = fopen("/var/www/html/mamaison.json","w") or die("Impossible de trouver ce fichier");
fwrite($fichierJson,$jso);
fclose($fichierJson);

echo "FIN DU PROGRAME : json_file.php \n";
?>