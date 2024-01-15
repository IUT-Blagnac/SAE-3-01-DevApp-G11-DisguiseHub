import {
    Given,
    When,
    And,
    Then,
} from "@badeball/cypress-cucumber-preprocessor";

Given("Je suis sur la page d'accueil2", () => {
  cy.visit("http://193.54.227.208/~saephp11/");
});

When("Je clique sur la catégorie {string}", (categorie) => {
    cy.get(':nth-child(4) > .categorie').click()
});

Then("Je devrait voir le produit de la catégorie {string} avec le nom {string}", (message) => {
  cy.contains(message).should("exist");
});
