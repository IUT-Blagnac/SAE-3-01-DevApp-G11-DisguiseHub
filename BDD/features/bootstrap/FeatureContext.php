<?php

use Behat\Behat\Context\Context;

class FeatureContext implements Context
{
    private $response;

    /**
     * @Given I am on the homepage
     */
    public function iAmOnTheHomepage()
    {
        // Votre logique pour accéder à la page d'accueil
        $this->response = "Welcome to My PHP Site";
    }

    /**
     * @Then I should see :arg1
     */
    public function iShouldSee($arg1)
    {
        // Votre logique pour vérifier si la réponse contient la chaîne attendue
        assert(strpos($this->response, $arg1) !== false);
    }
}
