Feature: Testing a PHP site

  Scenario: Check the home page
    Given I am on the homepage
    Then I should see "Welcome to My PHP Site"
