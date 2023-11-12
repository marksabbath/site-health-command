Feature: Checks a Health of a Site

  Background:
    Given a WP install

  Scenario: Check the healf of the site

    When I try `wp site-health check --format=table`
    Then STDOUT should be a table containing rows:
      | check                            | type        | status      |
      | WordPress Version                | Performance | recommended |
      | Plugin Version                   | Security    | recommended |
      | REST API Availability            | Performance | recommended |
      | Communication with WordPress.org | Security    | good        |
    And STDERR should be empty
    And the return code should be 0