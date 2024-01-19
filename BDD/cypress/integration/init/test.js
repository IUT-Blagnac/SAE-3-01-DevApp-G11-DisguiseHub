import { Given, Then } from '@badeball/cypress-cucumber-preprocessor';

Given('I visit the Hello World page', () => {
  cy.visit('http://google.fr');
});

Then('I should see the message {string}', (message) => {
  cy.contains(message).should('exist');
});
