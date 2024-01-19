Feature: Inscription Feature
  Feature en lien avec le CRUD de l'application

  Scenario: Création d'un compte
    Given Je suis sur la page de création d'un compte
    When Je remplis les données du formulaire de création
    And Je clique sur le bouton pour s'inscrire
    Then Je devrait voir le message "Inscription réussie" après l'inscription


