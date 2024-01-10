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
     * @Given A initial website
     */
    public function anInitWebsite()
    {
        // TODO: Implement the step definition for an empty basket
    }
    
    /**
     * @Then I see :arg1
     */
    public function iSee($arg1)
    {
    }
}