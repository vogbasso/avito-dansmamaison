<?php
echo "DEBUT DU FICHIER DES REQUETES : mysql_request.php \n";

//importation du fichier des functions servant à raccourcir les requêtes 
require('mysql_request_functions.php');


// TABLEAU LISTES DES OBJETS PRODUITS AVITO 
$listproducts = array();


/*** PREMIERE REQUETE Récupère la liste des produits ***/
//requi = "select * from wp_wc_product_meta_lookup wwpml inner join wp_posts wp on wwpml.product_id = wp.ID where wwpml.sku <> '' and wwpml.sku is not null and wp.post_status = 'publish' limit 10;";
$req = $conn->prepare("select * from wp_wc_product_meta_lookup wwpml inner join wp_posts wp on wwpml.product_id = wp.ID where wwpml.sku <> '' and wwpml.sku is not null and wp.post_status = 'publish';");
//$req = $conn->prepare("select wp_posts.ID, wp_posts.post_title, wp_pos from wp_posts where wp_posts.post_type='product' or wp_posts.post_type='product_variation' order by wp_posts.ID limit 10;");
//$reponse = $conn->query('select wp_posts.ID,wp_post_skr from wp_posts,wp_wc_product_meta_lookup AS wc_product where wp_posts.ID = wc_product.product_ID limit 20');
$req->execute();
//$req = avito_request($requi,$conn);
//print_r($req);



while($donne = $req->fetch()){ /*** BOUCLE POUR APPLER TOUS LES PRODUITS DE LA BASE DE DONNER ***/

   $id_produit = $donne['ID']; // affection de l'id du produit afin de récupérer les GUID des urls
   
   $avitoProduct = new avito_product(); // instantiation d'une variable Avito product

   $avitoProduct->id = remplace_point($donne['sku']); //sku à la place de ID pour AVITO
   
   $avitoProduct->title = $donne['post_title']; //Titre pour post_title pour Avito utf8_encode($donne['post_title']);
   

   $prix_de_vente = prix_min_vente($donne['min_price'],$donne['max_price']); // prix de vente est le prix minimum entre le prix max et le prix min
   $avitoProduct->price = $prix_de_vente; // ajout de prix de vente dans le modèle
   
   $avitoProduct->description = retire_url_description((string) $donne['post_content']); // s'assurer que c'est converti en chaîne de caractère

   $avitoProduct->published = $donne['post_status'] == 'publish' ? true : false; /// définir le status a publié ou non

   $avitoProduct->delivery = livraison_gratuite($prix_de_vente); // definir le statut de delivery a true ou false
   //$avitoProduct->inStockStatus = $donne['stock_status'] == 'instock' ? true : false; // définir le status du stock en Stock True, outofstock false 

   /***  Début de la  deuxième requête dans le but d'utiliser l'id pour récupérer cette informations ***/
   $req2 = $conn->prepare("select wp.post_id, wp.meta_key, wp.meta_value from wp_postmeta wp where (wp.meta_key = '_thumbnail_id' or wp.meta_key = '_product_image_gallery') and wp.post_id = :identifiant order by wp.meta_key desc limit 10;");
   $req2->execute(array("identifiant"=>$id_produit));
   // $req2 = $conn->prepare("select guid from wp_posts wp2 inner join (select meta_value from wp_postmeta wp where wp.post_id = :identifiant and meta_key = '_thumbnail_id') as meta_thumbnail on wp2.ID = meta_value ;");
      
   while($url_images = $req2->fetch()){ /*** BOUCLE DANS LE BUT DE CONTROLER SI LES IMAGES SONT DISPONIBLE AFIN DE POUVOIR CREER LE LES PRODUITS AVITO***/

      if( ($url_images['meta_key'] == '_thumbnail_id' or $url_images['meta_key']=='_product_image_gallery') and isset($url_images['meta_value']) and 0!= (int) $url_images['meta_value']){
        echo "Trouveé et voici la id_produit $id_produit avec la meta KEY ".$url_images['meta_key']." meta value: ".$url_images['meta_value']."\n";

        if($url_images['meta_key']=='_thumbnail_id'){// contrôle pour les thumbnails
         $identifiant_thumbnail = $url_images['meta_value'];
         $req3 = $conn->prepare("select guid from wp_posts wp where wp.ID = :identifiant_thumbnail;");
         $req3->execute(array("identifiant_thumbnail"=>$identifiant_thumbnail));
         
         while($guid_url = $req3->fetch()){
            array_push($avitoProduct->images,$guid_url['guid']);
         }
      }elseif($url_images['meta_key']=='_product_image_gallery'){
         $id_product_image_gallery = explode(",",$url_images['meta_value']);
         $i = 2;
         foreach($id_product_image_gallery as $id_gallery){
            $req4 = $conn->prepare("select guid from wp_posts wp where wp.ID = :id_product_image;");
            $req4->execute(array("id_product_image"=>$id_gallery));
            while($guid_url = $req4->fetch()){
               if($guid_url['guid']){
                  array_push($avitoProduct->images,$guid_url['guid']);
               }
               $i = $i+1;
            }
         }
      }
      
      }else{
         continue;
         echo "continuer le code à l'étape suivante \n";
      }
       // Ajouté le produit à la liste seulement quand il possède une image
   }
   if(sizeof($avitoProduct->images) != 0 ){
      array_push($listproducts,$avitoProduct);
   }
   echo "le nombre de produit est ".sizeof($listproducts);
   }
   echo "dans la page request \n";
?>