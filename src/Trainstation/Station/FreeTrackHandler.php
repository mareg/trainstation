<?php declare(strict_types=1);

namespace App\Trainstation\Station;

final class FreeTrackHandler
{
    private DispatchTrainFromTrack $dispatchTrainFromTrack;

    public function __construct(DispatchTrainFromTrack $dispatchTrainFromTrack)
    {
        $this->dispatchTrainFromTrack = $dispatchTrainFromTrack;
    }

    public function __invoke(FreeTrack $freeTrack)
    {
        $this->dispatchTrainFromTrack->dispatchTrainFromTrack($freeTrack);
    }
}
