<?php

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class ProductsContext implements Context
{

        /**
     * @Given i am in the products page
     */
    public function iAmInTheProductsPage()
    {
    }

    /**
     * @Then I see the product with the name :arg1
     */
    public function iSeeTheProductWithTheName($arg1)
    {
    }
}