<?php declare(strict_types=1);

namespace App\Trainstation\Station;

use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\Track\TrackNotFound;
use App\Trainstation\Station\Track\Tracks;
use App\Trainstation\Train\Train;

final class Station implements \JsonSerializable
{
    private StationId $stationId;
    private string $name;
    private Tracks $tracks;

    public function __construct(StationId $stationId, string $name, Tracks $tracks)
    {
        $this->stationId = $stationId;
        $this->name = $name;
        $this->tracks = $tracks;
    }

    public static function namedWithTracks(string $name, Tracks $tracks): Station
    {
        return new self(new StationId(), $name, $tracks);
    }

    public function stationId(): StationId
    {
        return $this->stationId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function dispatchTrain(Train $train): Track
    {
        foreach ($this->tracks->sortedSliceByPlatforms($train->preferredPlatformsOrder()) as $track) {
            if ($train->canUseTrack($track) && !$track->isOccupied()) {
                $track->dispatchTrain($train);
                return $track;
            }
        }

        throw NoTrackAvailable::forTrain($train);
    }

    public function jsonSerialize(): array
    {
        return [
            'station_id' => $this->stationId,
            'name' => $this->name,
            'tracks' => $this->tracks,
        ];
    }

    public function getTrackNumber(int $trackNumber): Track
    {
        foreach ($this->tracks as $track) {
            if ($track->number() === $trackNumber) {
                return $track;
            }
        }

        throw TrackNotFound::withTrackNumber($trackNumber);
    }
}
