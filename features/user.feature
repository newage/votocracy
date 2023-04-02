Feature: Get user's data

  Scenario: Get user's data
    Given there are user:
      | role_id | email               | name |
      | 3       | test_ne3u2n@test.no | Test |
    And the "Accept" request header is "application/hal+json"
    When I request "/test/api/user/1/"
    Then the response code is 200
    Then the response body contains JSON:
      """
      {
        "id": "@variableType(integer)",
        "name": "@variableType(string)",
        "_links": {
          "self": {
            "href": "@variableType(string)"
          }
        },
        "_embedded": {
          "applications": [
            {
              "id": "@variableType(integer)",
              "message": "@variableType(string)",
              "user": null,
              "_links": {
                "self": {
                  "href": "http://mezzio/test/api/application/1/"
                }
              }
            },
            {
              "id": 2,
              "message": "test",
              "user": null,
              "_links": {
                "self": {
                  "href": "http://mezzio/test/api/application/2/"
                }
              }
            },
            {
              "id": 3,
              "message": "test application",
              "user": null,
              "_links": {
                "self": {
                  "href": "http://mezzio/test/api/application/3/"
                }
              }
            }
          ]
        }
      }
      """

  Scenario:
    Given the "Accept" request header is "application/hal+json"
    When I request "/test/api/user/2/"
    Then the response code is 404
    And the response body contains JSON:
    """
    {
      "transaction": "@variableType(object)",
      "title": "Not found user",
      "type": "@variableType(string)",
      "status": 404,
      "detail": "User with this id is not found"
    }
    """
