import {
    Given,
    When,
    And,
    Then,
  } from "@badeball/cypress-cucumber-preprocessor";

Given("Je suis sur la page d'accueil", () => {
  cy.visit("http://193.54.227.208/~saephp11/");
});

Then("Je devrait voir le produit avec le nom {string}", (message) => {
  cy.contains(message).should("exist");
});
