// cypress/support/commands.js

Cypress.Commands.add('visitAndSetViewport', (url) => {
    cy.visit(url);
    cy.viewport(1920, 1080);
  });
  
  // Autres commandes personnalisées peuvent être ajoutées ici
  
  // Importez cette commande dans vos fichiers de test pour l'utiliser
  