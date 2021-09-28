<?php 

$servername = 'localhost';
$username = 'mamaison_live';
$password = 'f2ttZ42a';
$dbused = 'dansmamaison_live';

try{

    $conn = new PDO("mysql:host=$servername;dbname=$dbused",$username,$password);
    
    echo "succès dans la connection";

}catch(PDOException $e){

    echo "error dans la connection ". $e->getMessage(). " \n";
}

require('mysql_request.php');
require('mysql_con_close.php');

?>