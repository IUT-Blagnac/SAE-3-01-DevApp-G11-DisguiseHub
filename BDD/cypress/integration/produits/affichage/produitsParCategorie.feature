Feature: getProduitsParCategorie Feature

    Scenario: Affichage des produits par catégorie
        Given Je suis sur la page d'accueil2
        When Je clique sur la catégorie "Couples"
        Then Je devrait voir le produit de la catégorie "Couples" avec le nom "Père et Mère Noël"