<?php declare(strict_types=1);

namespace App\Infrastructure\InMemory;

use App\Trainstation\Station\DispatchTrain;
use App\Trainstation\Station\FindStation;
use App\Trainstation\Station\FreeTrack;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\TrackRepository;

final class TracksInMemoryRepository implements TrackRepository
{
    private FindStation $stations;

    public function __construct(FindStation $stations)
    {
        $this->stations = $stations;
    }

    public function dispatchTrainForTrack(DispatchTrain $dispatchTrain, Track $track): void
    {
        // nothing to do here
    }

    public function dispatchTrainFromTrack(FreeTrack $freeTrack): void
    {
        $station = $this->stations->findOneByStationId($freeTrack->stationId());

        $track = $station->getTrackNumber($freeTrack->trackNumber());

        $track->free();
    }
}
