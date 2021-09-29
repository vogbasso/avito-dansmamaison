<?php


$listproducts = array();
/*** PREMIERE REQUETE Récupérera la liste des produits ***/

$req = $conn->prepare("select * from wp_wc_product_meta_lookup wwpml inner join wp_posts wp on wwpml.product_id = wp.ID where wwpml.sku <> '' and wwpml.sku is not null and wp.post_status = 'publish' limit 2;");
//$req = $conn->prepare("select wp_posts.ID, wp_posts.post_title, wp_pos from wp_posts where wp_posts.post_type='product' or wp_posts.post_type='product_variation' order by wp_posts.ID limit 10;");
//$reponse = $conn->query('select wp_posts.ID,wp_post_skr from wp_posts,wp_wc_product_meta_lookup AS wc_product where wp_posts.ID = wc_product.product_ID limit 20');
$req->execute();

print_r($req);
/*** BOUCLE POUR APPLER TOUS LES PRODUITS DE LA BASE DE DONNER ***/
while($donne = $req->fetch()){
   $id_produit = $donne['ID'];
   echo "l'identifiant du produit $id_produit \n";
   $avitoProduct = new avito_product();
   $avitoProduct->id = $donne['sku']; //sku à la place de ID pour AVITO
   $avitoProduct->title = $donne['post_title']; //Titre pour post_title pour Avito utf8_encode($donne['post_title']);
   $avitoProduct->price = (int) min($donne['min_price'],$donne['max_price']);
   //echo "Voici la valeur de publish ".$donne['post_status'];
   $avitoProduct->published = $donne['post_status'] == 'publish' ? true : false;


   /***  Début de la  deuxième requête dans le but d'utiliser l'id pour récupérer cette informations ***/
      $req2 = $conn->prepare("select guid from wp_posts wp2 inner join (select meta_value from wp_postmeta wp where wp.post_id = :identifiant and meta_key = '_thumbnail_id') as meta_thumbnail on wp2.ID = meta_value ;");
      $req2->execute(array("identifiant"=>$id_produit));
      //print_r($req2);
      while($url_image = $req2->fetch()){
         array_push($avitoProduct->images,$url_image['guid']);
         
         //echo "URL GUID ".$url_image['guid'];
         
      }
   //var_dump($req2);
   array_push($listproducts,$avitoProduct);
   
    print_r($listproducts);
    //var_dump($donne);
    // echo $donne['0']."\n";
};

echo "étape \n";
//print_r($listproducts);


//echo string($reponse);
//var_dump($reponse);
//echo " \n";


echo "dans la page request \n";
?>