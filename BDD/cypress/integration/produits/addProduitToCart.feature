Feature: addProduitToCart Feature

    Scenario: Ajouter un produit à son panier
        Given Je suis sur la page de connexion2
        When Je me connecte à un compte et me rend sur la page d'accueil
        And Je clique sur le produit avec le nom "Père Noël"
        And Je clique sur le bouton d'ajout du produit dans le panier
        Then Le produit avec le nom "Père Noël" doit être présent dans mon panier