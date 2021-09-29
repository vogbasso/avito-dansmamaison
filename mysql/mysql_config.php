<?php 
// IMPORTER LE FICHIER DES PARAMERTRE DE CONNECTION à créer et à remplir car trop dangereux pour être sur github
require('mysql_hide_conn_variable.php');

try{

    $conn = new PDO("mysql:host=$servername;dbname=$dbused",$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "CONNECTION ETABLIE : fichier mysql_config.php \n";

}catch(PDOException $e){

    echo "ERROR DE CONNECTION : fichier mysql_config.php. Voici le message d'erreur ". $e->getMessage(). " \n";
}

//Insertion des fichiers request et du fichier fermertures de connection
require('mysql_request.php');
require('mysql_con_close.php');

?>