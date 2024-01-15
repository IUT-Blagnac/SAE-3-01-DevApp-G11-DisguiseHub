// cypress/integration/systemePanier.js

import { Given, When, Then } from '@badeball/cypress-cucumber-preprocessor';


const email = "christopher2211.angelique@gmail.com";
const motPasse = "Christopher.2211";

Given('Je me connecte au site et je visite la page d\'accueil', () => {
  cy.visit('http://193.54.227.208/~saephp11/compte/connexion.php');
  
  cy.get('#email').clear().type(email);
  cy.get('#mdp').clear().type(motPasse);

  cy.get('[style="width: 304px; height: 78px;"] > div > iframe').click()

  cy.get('button').click()

});

// When('Je clique sur le produit avec le nom {string}', (productName) => {
//   // Code pour cliquer sur le produit avec le nom donné
// });

// When('Je clique sur le bouton Ajouter au panier', () => {
//   // Code pour cliquer sur le bouton Ajouter au panier
// });

// When('Je visite mon panier', () => {
//   // Code pour visiter le panier
// });

// Then('Je doit voir le produit avec le nom {string}', (productName) => {
//   // Code pour vérifier que le produit est présent dans le panier
//   cy.contains(productName).should('exist');
// });