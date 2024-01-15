Feature: Système de Panier Feature
    En tant que client, je veux pouvoir consulter l'ensemble des produits 
    pour pouvoir visualiser le catalogue de Disguise'Hub.

  Scenario: Ajouter un produit dans son panier
    Given Je me connecte au site et je visite la page d'accueil
    When Je clique sur le produit avec le nom "Père Noël"
    And Je clique sur le bouton Ajouter au panier
    And Je visite mon panier
    Then Je doit voir le produits avec le nom "Père Noël"
