import {
    Given,
    When,
    And,
    Then,
} from "@badeball/cypress-cucumber-preprocessor";

Given("Je suis sur la page d'accueil3", () => {
  cy.visit("http://193.54.227.208/~saephp11/");
});

When("Je clique sur la barre de recherche", () => {
    cy.get('.left > .icon > .fa-solid').click()
});

When("Je saisis le nom du produit", () => {
    cy.get('input').type('Père Noël');

});

Then("Je devrait voir le produit avec le nom {string} après la recherche", (nomProduit) => {
    cy.get('button').click()
});
