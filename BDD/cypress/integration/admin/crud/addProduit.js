import {
    Given,
    When,
    And,
    Then,
} from "@badeball/cypress-cucumber-preprocessor";

function generateRandomProductName() {
    const adjectives = ['Red', 'Green', 'Blue', 'Elegant', 'Fantastic'];
    const nouns = ['Chair', 'Table', 'Lamp', 'Book', 'Plant'];
  
    const randomAdjective = adjectives[Math.floor(Math.random() * adjectives.length)];
    const randomNoun = nouns[Math.floor(Math.random() * nouns.length)];
  
    return `${randomAdjective} ${randomNoun}`;
}

let productName = ""

Given("Je suis connecter à un compte admin et je suis sur la page d'administration", () => {
    cy.visit("http://193.54.227.208/~saephp11/compte/connexion.php");

    cy.get('#email').type('christopher2211.angelique@gmail.com');
    cy.get('#mdp').type('Christopher.2211');

    cy.get('button').click();

    cy.get('[href="/~saephp11/admin"]').click()
});

When("Je clique sur le bouton d'ajout d'un produit", () => {
    cy.get('.button').click()
});

When("Je remplis les champs du formulaire", () => {
    const randomProductName = generateRandomProductName();
    productName = randomProductName

    cy.get('[name="nomProduit"]').type(randomProductName)
    cy.get('textarea').type('lorem ipsum')
    cy.get('[name="prixProduit"]').type(50)
    cy.get('[name="idCategorie"]').select(1)
    cy.get('[type="number"]').type(5)
    cy.get('[name="couleurProduit"]').type('rouge')
});


When("Je valide le formulaire", () => {
    cy.get('[type="submit"]').click()
});

Then("Le nouveau produit devrait être crée avec succès", () => {
    cy.get('.left > .icon > .fa-solid').click()
    cy.get('input').type(productName);
    cy.get('button').click()

    cy.contains(productName).should("exist");
});
