<?php
/***
 * Module name : avito_dansmamaison
 * Author : Vogel Paolo BASSO
 */

 // N'oubliez surtout pas de définir dans le fichier mysql_config.php les paramètres du serveur de base de donnée
 // définir dans le fichier json_file.php le chemin de la création serveur du fichier json 

 
header('Content-type: text/plain; charset=utf-8'); // définition de l'encodage utilisé pour le fichier

echo "DEBUT DU PROGRAMME : avito_dansmamaison.php \n";

/*** liste des fichiers importé dans le code de Avito***/


require('models/avito_product.php'); // importation du model de produit Avito

require('mysql/mysql_config.php'); // importation des paramètres mysql

require('json/json_config.php'); // importation des paramètres JSON

?>
