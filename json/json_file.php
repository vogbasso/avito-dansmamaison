<?php

// ouverture du fichier JSON sur le serveur.

$fichierJson = fopen("mamaison.json","w") or die("Impossible de trouver ce fichier");
fwrite($fichierJson,$jso);
fclose($fichierJson);

echo "on est dans le fichier de gestion du file avito";
?>