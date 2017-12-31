Feature: The actor API's endpoint
  In order to manipulate actors data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  @repository
  Scenario: Fetch an actor data
    Given the following actor(s) exist:
    |actor_id|first_name|last_name|
    |1       |Jessica   |Hyde     |
    |2       |Joe       |Doe      |
    When I send a GET request to "api/actors/1"
    Then the response code should be 200
    And the response should contain JSON:
    """
    {"actorId":1,"firstName":"Jessica","lastName":"Hyde"}
    """
