Feature: Test application API's

  Scenario: Get one application's data
    Given the "Accept" request header is "application/hal+json"
    When I request "/test/api/application/1/"
    Then the response code is 200

  Scenario: Not found application
    Given the "Accept" request header is "application/hal+json"
    When I request "/test/api/application/2/"
    Then the response code is 404

  Scenario: Get list of applications
    Given the "Accept" request header is "application/hal+json"
    When I request "/test/api/applications/"
    Then the response code is 200