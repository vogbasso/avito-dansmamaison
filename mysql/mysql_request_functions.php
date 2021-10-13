<?php

echo "DEBUT DU FICHIER des functions mysql réutilisable : mysql_request_functions.php \n";

function retire_url_description ($description){
    $allowed_tags = array("html", "body", "b", "br", "em", "hr", "i", "li", "ol", "p", "s", "span", "table", "tr", "td", "u", "ul","strong");
    return strip_tags($description);
}

function remplace_point($ID_A_TRAITER){
    $id_traiter = str_replace('.','-',$ID_A_TRAITER);
    return $id_traiter;
}
?>