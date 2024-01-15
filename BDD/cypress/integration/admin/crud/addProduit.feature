Feature: addProduit Feature

    Scenario: Ajout d'un produit
        Given Je suis connecter à un compte admin et je suis sur la page d'administration
        When Je clique sur le bouton d'ajout d'un produit
        And Je remplis les champs du formulaire
        And Je valide le formulaire
        Then Le nouveau produit devrait être crée avec succès