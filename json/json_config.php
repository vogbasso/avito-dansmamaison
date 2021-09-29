<?php
echo "Json file \n";
//print_r($listproducts);
//var_dump($listproducts);
$jso = json_encode($listproducts, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
echo json_last_error_msg();
echo "LA PARTIE DU JSON \n";
var_dump($jso);

require('json_file.php');

?>