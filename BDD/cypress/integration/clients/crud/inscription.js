import {
  Given,
  When,
  And,
  Then,
} from "@badeball/cypress-cucumber-preprocessor";

function generateRandomEmail() {
  const randomString = Math.random().toString(36).substring(7); // Génère une chaîne aléatoire
  const email = `${randomString}@gmail.com`;
  return email;
}

Given("Je suis sur la page de création d'un compte", () => {
  cy.visit("http://193.54.227.208/~saephp11/compte/inscription.php");
});

When("Je remplis les données du formulaire de création", () => {
  const randomEmail = generateRandomEmail();

  cy.get("#prenom").type("Christopher");
  cy.get("#nom").type("Marie-Angélique");
  cy.get("#genre").select("Homme");
  cy.get("#dtn").type("2003-01-22");
  cy.get("#email").type(randomEmail);
  cy.get("#tel").type("0648616251");
  cy.get("#mdp").type("Christopher.2211");
});

When("Je clique sur le bouton pour s\'inscrire", () => {
  cy.get("button").click();
});

Then("Je devrait voir le message {string} après l'inscription", (message) => {
  cy.contains(message).should("exist");
});
