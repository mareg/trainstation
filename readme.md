# Trainstation

Build a simple API to manage status of the tracks at the station, this API would be connected
with the station's infrastructure. 

Station
 - has at least 2 tracks with long platforms
 - tracks have sequential numbers: 1, 2, 3...

Tracks
 - can have a short platform
 - can have a long platform
 - can have no platform

Trains
 - train has a train number (alphanumeric, examples: `IC345`, `RE3139` or `39131`) and a type
 (`local`, `regional` and `fast`)
 - fast trains don't stop at the station and should use the track without platform (preferred)
 or track with a long platform 
 - regional trains stop at the long platform
 - local trains stop at any platform

For simplicity, it does not matter if train is stopping or not, it still needs to occupy the
track to get through the station.

API endpoints:

`GET /stations/{id}` to list all tracks with their number, type, status (used or not) and train (if any)

`POST /station/{id}` with a payload
```json
{"number": "IC345", "type": "fast" }
```
to specify that train has arrived and is about to enter the station
Responses:
 * `201` status code with a location header for the platform train got assigned
 * `409` status code with a message that no tracks are available at the moment

`PUT /station/{id}/tracks/{track_number}` to release the track used by a train
 * `204` status code confirming release of the platform
