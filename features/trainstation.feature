Feature:
  In order to have a visibility of track occupancy
  As a station manager
  I want to be an automated track assignment system

  Scenario: Local train can stop at a track with short platform
    Given station named Reading has tracks
      | track number | platform |
      | 1             | short    |
      | 2             | short    |
    When I dispatch a local train number L3321
    Then train number L3321 should occupy track number 1

  Scenario: Local train can stop at a track with long platform if there is no short platform
    Given station named Reading has tracks
      | track number | platform |
      | 1             | long     |
      | 2             | long     |
    When I dispatch a local train number L3321
    Then train number L3321 should occupy track number 1

  Scenario: Regional train can stop at the long platform
    Given station named Reading has tracks
      | track number | platform |
      | 1             | short    |
      | 2             | short    |
      | 3             | long     |
      | 4             | long     |
    When I dispatch a regional train number RE1367
    Then train number RE1367 should occupy track number 3

  Scenario: High speed train can pass on the track without platform
    Given station named Reading has tracks
      | track number | platform |
      | 1             | short    |
      | 2             | short    |
      | 3             |          |
    When I dispatch a fast train number IC3317
    Then train number IC3317 should occupy track number 3

  Scenario: High speed train can pass on the track with long platform
    Given station named Reading has tracks
      | track number | platform |
      | 1             | short    |
      | 2             | short    |
      | 3             | long     |
      | 4             | long     |
    When I dispatch a fast train number IC3317
    Then train number IC3317 should occupy track number 3

  Scenario: High speed train prefers a track without platform when long platforms are available
    Given station named Reading has tracks
      | track number | platform |
      | 1             | short    |
      | 2             | short    |
      | 3             | long     |
      | 4             | long     |
      | 5             |          |
    When I dispatch a fast train number IC3317
    Then train number IC3317 should occupy track number 5

  Scenario: Local train cannot enter the station if all tracks are occupied
    Given station named Reading has tracks with trains
      | track number | platform | train |
      | 1             | short    | L3315 |
      | 2             | short    | L3351 |
    When I dispatch a local train number IC3317
    Then I should be notified of no available tracks

  Scenario: Local train cannot enter the station if all tracks with platform are occupied
    Given station named Reading has tracks with trains
      | track number | platform | train |
      | 1             | short    | L3315 |
      | 2             | short    | L3351 |
      | 3             |          |       |
      | 4             |          |       |
    When I dispatch a local train number IC3317
    Then I should be notified of no available tracks

  Scenario: Regional train cannot enter the station if all tracks with platform are occupied
    Given station named Reading has tracks with trains
      | track number | platform | train |
      | 1             | short    |       |
      | 2             | short    |       |
      | 3             | long     | L3315 |
      | 4             | long     | L3351 |
      | 5             |          |       |
      | 6             |          |       |
    When I dispatch a regional train number RE3317
    Then I should be notified of no available tracks

  Scenario: Track is released when train leaves the station
    Given station named Reading has tracks with trains
      | track number | platform | train |
      | 1             | short    |       |
      | 2             | short    |       |
      | 3             | long     | L3315 |
      | 4             | long     |       |
      | 5             |          |       |
      | 6             |          |       |
    When train frees track number 3
    Then track number 3 should not be occupied