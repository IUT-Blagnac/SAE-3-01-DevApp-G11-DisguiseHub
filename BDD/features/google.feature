Feature: Google 

Scenario: Homepage

    Given I am on the homepage
    Then I should see "Recherche Google"

@javascript
Scenario: Search

    Given I am on the homepage
    When I fill in "gbqfq" with "Grafikart"
    And I wait for 1 seconds
    Then I should see "Grafikart.fr"