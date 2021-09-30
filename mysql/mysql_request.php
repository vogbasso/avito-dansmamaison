<?php
echo "DEBUT DU FICHIER DES REQUETES : mysql_request.php \n";

//importation du fichier des functions servant à raccourcir les requêtes 
require('mysql_request_functions.php');


// TABLEAU LISTES DES OBJETS PRODUITS AVITO 
$listproducts = array();


/*** PREMIERE REQUETE Récupère la liste des produits ***/
//requi = "select * from wp_wc_product_meta_lookup wwpml inner join wp_posts wp on wwpml.product_id = wp.ID where wwpml.sku <> '' and wwpml.sku is not null and wp.post_status = 'publish' limit 10;";
$req = $conn->prepare("select * from wp_wc_product_meta_lookup wwpml inner join wp_posts wp on wwpml.product_id = wp.ID where wwpml.sku <> '' and wwpml.sku is not null and wp.post_status = 'publish' limit 10;");
//$req = $conn->prepare("select wp_posts.ID, wp_posts.post_title, wp_pos from wp_posts where wp_posts.post_type='product' or wp_posts.post_type='product_variation' order by wp_posts.ID limit 10;");
//$reponse = $conn->query('select wp_posts.ID,wp_post_skr from wp_posts,wp_wc_product_meta_lookup AS wc_product where wp_posts.ID = wc_product.product_ID limit 20');
$req->execute();
//$req = avito_request($requi,$conn);
//print_r($req);
/*** BOUCLE POUR APPLER TOUS LES PRODUITS DE LA BASE DE DONNER ***/
while($donne = $req->fetch()){
   $id_produit = $donne['ID'];
   //echo "l'identifiant du produit $id_produit \n";
   $avitoProduct = new avito_product();
   $avitoProduct->id = $donne['sku']; //sku à la place de ID pour AVITO
   $avitoProduct->title = $donne['post_title']; //Titre pour post_title pour Avito utf8_encode($donne['post_title']);
   $avitoProduct->price = (int) min($donne['min_price'],$donne['max_price']);
   $avitoProduct->description = (string) $donne['post_content'];
   //echo "Voici la valeur de publish ".$donne['post_status'];
   $avitoProduct->published = $donne['post_status'] == 'publish' ? true : false;


   /***  Début de la  deuxième requête dans le but d'utiliser l'id pour récupérer cette informations ***/
     // $req2 = $conn->prepare("select guid from wp_posts wp2 inner join (select meta_value from wp_postmeta wp where wp.post_id = :identifiant and meta_key = '_thumbnail_id') as meta_thumbnail on wp2.ID = meta_value ;");
      
      $req2 = $conn->prepare("select wp.post_id, wp.meta_key, wp.meta_value from wp_postmeta wp where (wp.meta_key = '_thumbnail_id' or wp.meta_key = '_product_image_gallery') and wp.post_id = :identifiant limit 10;");
      $req2->execute(array("identifiant"=>$id_produit));
      
      //print_r($req2);
     // $i=1;
      
      while($url_images = $req2->fetch()){

        if ($url_images['meta_key'] and $url_images['meta_key']=='_thumbnail_id'){
            $identifiant_thumbnail = $url_images['meta_value'];
            $req3 = $conn->prepare("select guid from wp_posts wp where wp.ID = :identifiant_thumbnail;");
            $req3->execute(array("identifiant_thumbnail"=>$identifiant_thumbnail));
               while($guid_url = $req3->fetch()){
                  if($guid_url['guid']){
              //       echo $guid_url['guid']."\n";
                     array_push($avitoProduct->images,array("url1"=>$guid_url['guid']));
                  }
               }

            //echo $url_images['meta_key']."et la valeur ".$url_images['meta_value']." \n" ;
        }elseif($url_images['meta_key'] and $url_images['meta_key']=='_product_image_gallery'){
           //echo "produit galerie disponilvle \n";

           $id_product_image_gallery = explode (",",$url_images['meta_value']);
          // print_r ($id_product_image_gallery);

           //$length = sizeof($id_product_image_gallery);
           $i = 2;
           foreach($id_product_image_gallery as $id_product){
            //echo "Image product id : $id_product \3";
            $req4 = $conn->prepare("select guid from wp_posts wp where wp.ID = :id_product_image;");
            $req4->execute(array("id_product_image"=>$id_product));
              //print_r($req4);
            
              while($guid_url = $req4->fetch()){
                // echo "La valeur du l'url pour l'id : $id_product et son url : ".$guid_url['guid']."\n";
                if($guid_url['guid']){

                  array_push($avitoProduct->images,array("url$i"=>$guid_url['guid']));

                }
                $i = $i+1;
              }
           }
           //echo "Longueur de l'array : $length \n";
           
           
           //   while($guid_url = $req4->fetch()){
                 //if($guid_url['guid']){
                 //   echo $guid_url['guid']."\n";
                 //   array_push($avitoProduct->images,array("url1"=>$guid_url['guid']));
                // }
            //  }

          // echo $url_images['meta_key']."et la valeur ".$url_images['meta_value']." \n" ;

        }
//         }else{

           // echo "missing \n";
         //}
       
         //array_push($avitoProduct->images,array("url$i"=>$url_images['guid']));
         
        // $i = $i +1;
         //echo "URL GUID ".$url_image['guid'];
     
      }

   /*** Début de la 3ème requêtes ***/
   //$req3 = $conn->prepare();
   //$req3->execute(array("identifiant"=>$id_produit));

   //var_dump($req2);
   array_push($listproducts,$avitoProduct);
   
   // print_r($listproducts);
    //var_dump($donne);
    // echo $donne['0']."\n";
};

//echo "étape \n";
//print_r($listproducts);


//echo string($reponse);
//var_dump($reponse);
//echo " \n";


echo "dans la page request \n";
?>