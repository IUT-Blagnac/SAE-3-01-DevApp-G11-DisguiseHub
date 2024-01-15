import {
    Given,
    When,
    And,
    Then,
  } from "@badeball/cypress-cucumber-preprocessor";

Given("Je suis sur la page de connexion", () => {
  cy.visit("http://193.54.227.208/~saephp11/compte/connexion.php");
});

When("Je remplis les données du formulaire de connexion", () => {
    cy.get('#email').type('christopher2211.angelique@gmail.com');
    cy.get('#mdp').type('Christopher.2211');
});

When("Je clique sur le bouton pour se connecter", (outon) => {
    cy.get('button').click();
});

Then("Je devrait voir le message {string} après la connexion", (message) => {
  cy.contains(message).should("exist");
});
