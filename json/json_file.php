<?php

/*** Ouverture du fichier JSON sur le serveur ***/ 

// JSON LOCAL AU FICHIER
$fichierJson = fopen("mamaison.json","w") or die("Impossible de trouver ce fichier");
fwrite($fichierJson,$jso);
fclose($fichierJson);

// JSON SUR LE SERVEUR APACHCE DANS LE DOSSIER HTML
$fichierJson = fopen("/var/www/html/mamaison.json","w") or die("Impossible de trouver ce fichier");
fwrite($fichierJson,$jso);
fclose($fichierJson);

echo "FIN DU FICHIER JSON_FILE \n";
?>