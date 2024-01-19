import {
    Given,
    When,
    And,
    Then,
} from "@badeball/cypress-cucumber-preprocessor";

Given("Je suis sur la page de connexion2", () => {
  cy.visit("http://193.54.227.208/~saephp11/compte/connexion.php");
});

When("Je me connecte à un compte et me rend sur la page d'accueil", () => {
    cy.get('#email').type('christopher2211.angelique@gmail.com');
    cy.get('#mdp').type('Christopher.2211');

    cy.get('button').click();
});

When("Je clique sur le produit avec le nom {string}", (nomProduit) => {
  cy.visit("http://193.54.227.208/~saephp11/");

  cy.get('[href="/~saephp11/produit.php?id=100000"]').click()
});


When("Je clique sur le bouton d'ajout du produit dans le panier", () => {
  cy.get('button').click()
});

Then("Le produit avec le nom {string} doit être présent dans mon panier", (nomProduit) => {
    cy.get('.fa-regular').click();
    cy.contains('Père Noël').should('exist');
});
