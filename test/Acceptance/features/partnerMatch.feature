Feature: Partner match
  Scenario: Should be able to enter a partner match result
    When I add a new partner match result
    Then I should see the match in my list
    And And the match is not valid

  Scenario: I can cancel a partner match if it was not validated by the opponent
    Given I have enter a partner match result not validated yet
    When I cancel the partner match
    Then The partner match gets cancelled
    And The opponent can't validate the result anymore

  Scenario: A partner match can be validated in max 7 days since it was played
    Given Today is "2020-03-29"
    When I try to validate a partner match played on "2020-03-22"
    Then The partner match can't be validated
    And The partner match status is expired
    When I try to validate a partner match played on "2020-03-23"
    Then The partner match is validated


  Scenario: Maximum number of partner matches in a month between april and october is 5
    Given Today is "2020-05-23"
    And I have already added 5 partner matches in the current month
    When I try to add a new partner match
    Then I am not allowed to add the partner match

  Scenario: Maximum number of partner matches in a month between november and march is 3
    Given Today is "2020-11-23"
    And I have already added 3 partner matches in the current month
    When I try to add a new partner match
    Then I am not allowed to add the partner match

  Scenario: Maximum number of partner matches in a month with the same opponent is 2
    Given I already added 2 partner matches with the same opponent in the current month
    When I try to add a new partner match with the same opponent in the same month
    Then I am not allowed to add the partner match

  Scenario: Maximum number of partner matches in a year with the same opponent is 8
    Given I already added 8 partner matches with the same opponent in the current year
    When I try to add a new partner match with the same opponent in the same year
    Then I am not allowed to add the partner match

  Scenario: Opponents level difference should not be greater then 2
    Given I have an account with game level 6
    And There is an opponent account with game level 8
    When I try to add a partner match with this opponent
    Then I am not allowed to add the partner match

