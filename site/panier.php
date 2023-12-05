
<?php

// Vérifiez si le formulaire est soumis

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the product ID and quantity from the form
        $productId = $_POST['id'];
        $quantity = $_POST['amount'];

        // Créer un tableau pour stocker les produits dans le panier
        $cart = [];

        // Vérifiez si le cookie de panier existe déjà
        if (isset($_COOKIE['cart'])) {
            // Ajouter le produit au panier
            $cart = json_decode($_COOKIE['cart'], true);
        }

        // Ajouter le produit au panier
        $cart[$productId] = $quantity;

        // Stocker les données de panier mises à jour dans le cookie
        setcookie('cart', json_encode($cart), time() + (86400 * 30), '/'); // Le cookie expire dans 30 jours

        // Rediriger l'utilisateur vers la page du produit
        header("Location: /product.php?id=$productId");
        exit;
    }

?>
