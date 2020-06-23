<?php declare(strict_types=1);

namespace App\Trainstation\Station;

use App\Trainstation\Station\Track\Track;

final class DispatchTrainHandler
{
    private FindStation $stations;

    private DispatchTrainForTrack $dispatchTrainForTrack;

    public function __construct(FindStation $stations, DispatchTrainForTrack $dispatchTrainForTrack)
    {
        $this->stations = $stations;
        $this->dispatchTrainForTrack = $dispatchTrainForTrack;
    }

    public function __invoke(DispatchTrain $dispatchTrain): Track
    {
        $station = $this->stations->findOneByStationId($dispatchTrain->stationId());

        $track = $station->dispatchTrain($dispatchTrain->train());

        $this->dispatchTrainForTrack->dispatchTrainForTrack($dispatchTrain, $track);

        return $track;
    }
}
