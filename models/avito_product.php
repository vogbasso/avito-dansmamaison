<?php
class avito_product{

    // Propriété définissant le modèle de produit à envoyer sur Avito
    public $id; //identifiant sku or ugs obligatoire
    public $title; //titre de l'article required max 50 caractères obligatoire
    public $published = true; //publier valeur par défaut TRUE
    public $type = "sell"; //Type rent ou sell default sell
    public $category = 3020;
    public $price; // prix de l'article (entre prix promo et prix normal)
    public $phone = "0522275438"; // téléphone du shop par défaut;
    public $city = 5; //par défaut casablanca code 5
    public $area = null;  //recommander AREA IDS
    public $itemcondition = 0; // par défaut 0 pour article neuf
    public $images = array(); // tableau des url des images if supérieur à 8 les 8 premiers seront chargé


  //  public $sku; // sku ou ugs de l'article
   // public $category; // seulement la catéogie principale
   // public $tagsList; // la liste des étiquettes du produits pour mieux le référencer
   // public $description;
   // public $resume;
   // public $product_url;
   // public $product_imageLink; //
   // public $product_imageLinkS; //
}
echo "Avito product models \n";
//$avito_product = new avito_produit_model();

//$avito_product['title_product'] = "Hamza mon bébé";
//var_dump(new avito_produit());
?>