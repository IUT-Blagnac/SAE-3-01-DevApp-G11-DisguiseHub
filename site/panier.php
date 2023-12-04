<?php

// Classe représentant un produit
class Product {
    public $id;
    public $name;
    public $price;
    
    public function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }
}

// Classe représentant le panier
class Cart {
    public $products;
    
    public function __construct() {
        $this->products = [];
    }
    
    // Ajouter un produit au panier
    public function addProduct($product) {
        $this->products[] = $product;
    }
    
    // Afficher le panier
    public function displayCart() {
        foreach ($this->products as $product) {
            echo "Produit : " . $product->name . " - Prix : " . $product->price . "<br>";
        }
    }
    
    // Modifier la quantité d'un produit dans le panier
    public function updateQuantity($productId, $quantity) {
        foreach ($this->products as $product) {
            if ($product->id == $productId) {
                $product->quantity = $quantity;
                break;
            }
        }
    }
    
    // Supprimer un produit du panier
    public function removeProduct($productId) {
        foreach ($this->products as $key => $product) {
            if ($product->id == $productId) {
                unset($this->products[$key]);
                break;
            }
        }
    }
}

// Classe représentant les consultations de produits
class ProductHistory {
    public $products;
    
    public function __construct() {
        $this->products = [];
    }
    
    // Ajouter une consultation de produit
    public function addProduct($product) {
        $this->products[] = $product;
    }
    
    // Visualiser les dernières consultations de produits
    public function displayHistory() {
        foreach ($this->products as $product) {
            echo "Produit consulté : " . $product->name . "<br>";
        }
    }
}

// Classe représentant les points de fidélité
class LoyaltyPoints {
    public $points;
    
    public function __construct() {
        $this->points = 0;
    }
    
    // Ajouter des points de fidélité
    public function addPoints($amount) {
        $this->points += $amount;
    }
    
    // Utiliser des points de fidélité
    public function usePoints($amount) {
        if ($this->points >= $amount) {
            $this->points -= $amount;
            return true;
        } else {
            return false;
        }
    }
}

// Création d'un produit
$product1 = new Product(1, "Produit 1", 10.99);

// Création d'un panier
$cart = new Cart();

// Ajout du produit au panier
$cart->addProduct($product1);

// Affichage du panier
$cart->displayCart();

// Modification de la quantité du produit dans le panier
$cart->updateQuantity(1, 2);

// Suppression du produit du panier
$cart->removeProduct(1);

// Création d'un historique de consultations de produits
$history = new ProductHistory();

// Ajout d'une consultation de produit
$history->addProduct($product1);

// Affichage de l'historique des consultations de produits
$history->displayHistory();

// Création des points de fidélité
$loyaltyPoints = new LoyaltyPoints();

// Ajout de points de fidélité
$loyaltyPoints->addPoints(100);

// Utilisation de points de fidélité
if ($loyaltyPoints->usePoints(50)) {
    echo "Points de fidélité utilisés avec succès";
} else {
    echo "Pas assez de points de fidélité";
}

?>
