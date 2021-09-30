<?php
class avito_product{

    // Propriété définissant le modèle de produit à envoyer sur Avito
    
    public $id; //identifiant sku or ugs obligatoire
    public $title; //titre de l'article required max 50 caractères obligatoire
    public $description=""; // description du produit
    public $published = true; //publier valeur par défaut TRUE
    public $type = "sell"; //Type rent ou sell default sell
    public $category = 3020;
    public $price; // prix de l'article (entre prix promo et prix normal)
    public $phone = "0520163443"; // téléphone du shop par défaut;
    public $city = 5; //par défaut casablanca code 5
    public $area = null;  //recommander AREA IDS
    public $itemcondition = 0; // par défaut 0 pour article neuf
    public $images = array(); // tableau des url des images if supérieur à 8 les 8 premiers seront chargé
    public $inStockStatus;
    
    public $delivery = true; //option de livraison par défaut à true;
}

echo "Avito product models Class : avito_product.php \n";

?>