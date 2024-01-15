Feature: Connexion Feature

    Scenario: Connexion à un compte 
        Given Je suis sur la page de connexion
        When Je remplis les données du formulaire de connexion
        And Je clique sur le bouton pour se connecter
        Then Je devrait voir le message "Mon compte" après la connexion