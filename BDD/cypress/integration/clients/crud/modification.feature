Feature: Modification Feature
  En tant que client, je veux pouvoir modifier les informations de mon compte

  Scenario: Modification d'un compte
    Given Je suis connecté à un compte et me situe sur la page de mes informations
    When Je clique sur le bouton de modification
    And Je remplis les champs du formulaire de modification
    And Je valide le formulaire de modification
    Then Le nom doit avoir été modifier


