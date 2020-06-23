<?php declare(strict_types=1);

namespace App\Trainstation\Station;

interface DispatchTrainFromTrack
{
    public function dispatchTrainFromTrack(FreeTrack $freeTrack): void;
}
