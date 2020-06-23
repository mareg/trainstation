<?php declare(strict_types=1);

namespace App\Trainstation\Station;

use App\Trainstation\Station\Track\Track;

interface DispatchTrainForTrack
{
    public function dispatchTrainForTrack(DispatchTrain $dispatchTrain, Track $track): void;
}
