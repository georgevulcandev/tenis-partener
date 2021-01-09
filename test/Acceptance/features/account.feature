Feature: Create a new account
  Scenario: Should be able to successfully create a new account on website
    Given I am new to the website
    When I create a new account
    Then I should receive a confirmation email
    And The account type is free
    And The account is not valid

  Scenario: Should be able to validate my account using the link in the confirmation email
    Given I have created an account and is not valid yet
    When I click on the confirmation link
    Then My account is validated

  Scenario: Password should be stored as hashed
    Given I am new to the website
    When I create a new account
    Then The password must be hashed

  Scenario: Account already exists
    Given There is already an account with email address "test@tenispartener.com"
    When I try to create a new account using the same email address
    Then The account should not be created

  Scenario: You must be at least 11 years old to create an account
    Given I am new to the website
    When I try to create a new account having less then 11 years old
    Then The account should not be created

  Scenario: Should be able to upgrade a free account
    Given I have a free account
    When I make a success payment to upgrade my account
    Then Then my account is upgraded

  Scenario: Premium account cannot be upgraded anymore
    Given I have a premium account
    When I want to upgrade my account
    Then I shouldn't be allowed to upgrade my account

  Scenario: Summer and premium accounts need to be renew avery year
    Given I have a summer or premium account for the current year
    When I access my account and the availability is expired
    Then My account is switch back to a free account
