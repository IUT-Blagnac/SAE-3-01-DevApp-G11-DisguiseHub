<?php

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given An empty basket
     */
    public function anEmptyBasket()
    {
        // TODO: Implement the step definition for an empty basket
    }

    /**
     * @Given A product is added to the basket
     */
    public function aProductIsAddedToTheBasket()
    {
        // TODO: Implement the step definition for adding a product to the basket
    }

    /**
     * @Then The basket price is :arg1€
     */
    public function theBasketPriceIsEur($arg1)
    {
        // TODO: Implement the step definition for verifying the basket price
    }
}