<?php

echo "DEBUT DU FICHIER des functions mysql réutilisable : mysql_request_functions.php \n";

function prix_min_vente($prix_min,$prix_max){ // return le résultat de la comparaison entre le prix min et le prix max

    $prix_vente = (int) min($prix_min,$prix_max);
    
    return $prix_vente;

}

function livraison_gratuite($prix_de_vente){ // défini si la livraison est gratuite ou pas.
    $gratuit = $prix_de_vente <= 500 ? true : false;
    return $gratuit;
}

function retire_url_description ($description){// suppression des urls dans la description
    $allowed_tags = array("html", "body", "b", "br", "em", "hr", "i", "li", "ol", "p", "s", "span", "table", "tr", "td", "u", "ul","strong");
    return strip_tags($description);
}

//function pour le traitement de la description du produit
function traitement_description($donne_content,$post_parent_id){
    if ($post_parent_id > 0){// traitement pour les produits ayant des variants
        global $conn;
        $reqvariation = $conn->prepare("select wp.post_content from wp_posts wp where wp.ID = :identifiant;");
        $reqvariation->execute(array("identifiant"=>$post_parent_id));
        $description="";
        while($donne = $reqvariation->fetch()){
            $description = retire_url_description((string) $donne['post_content']);
        }
        return $description;
    }else{
        $description = retire_url_description((string) $donne_content); // s'assurer que c'est converti en chaîne de caractère
        return $description;
    }
}

function remplace_point($ID_A_TRAITER){ //replacement des des points par des tirets dans les SKU
    $id_traiter = str_replace('.','-',$ID_A_TRAITER);
    return $id_traiter;
}

?>