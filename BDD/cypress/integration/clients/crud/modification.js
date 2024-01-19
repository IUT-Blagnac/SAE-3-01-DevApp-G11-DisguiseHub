import {
    Given,
    When,
    And,
    Then,
  } from "@badeball/cypress-cucumber-preprocessor";

  const name = ""
  let editName = ""

  function generateRandomName() {
    const alphabet = 'abcdefghijklmnopqrstuvwxyz';
    const nameLength = Math.floor(Math.random() * 5) + 5; // Longueur du prénom entre 5 et 10 caractères
    let randomName = '';
  
    for (let i = 0; i < nameLength; i++) {
      const randomIndex = Math.floor(Math.random() * alphabet.length);
      const randomChar = alphabet.charAt(randomIndex);
      randomName += randomChar;
    }
  
    // Mettre la première lettre en majuscule pour simuler un prénom
    return randomName.charAt(0).toUpperCase() + randomName.slice(1);
  }
  
  Given("Je suis connecté à un compte et me situe sur la page de mes informations", () => {
    cy.visit("http://193.54.227.208/~saephp11/compte/connexion.php");

    cy.get('#email').type('christopher2211.angelique@gmail.com');
    cy.get('#mdp').type('Christopher.2211');

    cy.get('button').click();

    cy.get('[href="/~saephp11/compte/informations.php"]').click()
  });
  
  When("Je clique sur le bouton de modification", () => {
    cy.get('[action="modification_informations.php"] > input').click()
  });
  
  When("Je remplis les champs du formulaire de modification", () => {
    const randomFirstName = generateRandomName();
    editName = randomFirstName
    cy.get('[name="new_nom"]').clear().type(randomFirstName)
  });

  When("Je valide le formulaire de modification", () => {
    cy.get('[type="submit"]').click()
  });
  
  Then("Le nom doit avoir été modifier", () => {
    cy.get(':nth-child(1) > .label_valeur')
  .should('not.have.text', name);
  });
  