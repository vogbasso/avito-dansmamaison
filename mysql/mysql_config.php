<?php 

$servername = 'localhost';
$username = 'mamaison_live';
$password = 'f2ttZ42a';
$dbused = 'dansmamaison_live';

try{

    $conn = new PDO("mysql:host=$servername;dbname=$dbused",$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "succès dans la connection";

}catch(PDOException $e){

    echo "error dans la connection ". $e->getMessage(). " \n";
}

require('mysql_request.php');
require('mysql_con_close.php');

?>