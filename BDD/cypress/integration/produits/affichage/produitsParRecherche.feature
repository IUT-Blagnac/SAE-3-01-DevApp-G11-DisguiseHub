Feature: getProduitsParRecherche Feature

    Scenario: Affichage des produits par recherche
        Given Je suis sur la page d'accueil3
        When Je clique sur la barre de recherche
        And Je saisis le nom du produit
        Then Je devrait voir le produit avec le nom "Père Noël" après la recherche