<?php


$listproducts = array();
// récupérer la liste des produits et identifiant de produit de la base de donnée

$req = $conn->prepare("select wp_posts.ID, wp_posts.post_title from wp_posts where wp_posts.post_type between 'product' and 'product_variation' order by wp_posts.ID limit 10;");
//$req = $conn->prepare("select wp_posts.ID, wp_posts.post_title, wp_pos from wp_posts where wp_posts.post_type='product' or wp_posts.post_type='product_variation' order by wp_posts.ID limit 10;");
//$reponse = $conn->query('select wp_posts.ID,wp_post_skr from wp_posts,wp_wc_product_meta_lookup AS wc_product where wp_posts.ID = wc_product.product_ID limit 20');
$req->execute();
while($donne = $req->fetch()){
   $avitoProduct = new avito_product();
   $avitoProduct->id = $donne['ID'];
   $avitoProduct->title = $donne['post_title']; //utf8_encode($donne['post_title']); 
   array_push($listproducts,$avitoProduct);
   
    //print_r($listproducts);
    //var_dump($donne);
    // echo $donne['0']."\n";
};

echo "étape \n";
print_r($listproducts);


//echo string($reponse);
//var_dump($reponse);
//echo " \n";


echo "dans la page request \n";
?>