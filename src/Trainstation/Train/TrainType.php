<?php declare(strict_types=1);

namespace App\Trainstation\Train;

use App\Trainstation\Station\Track\Track;

interface TrainType
{
    public function canUseTrack(Track $track): bool;

    public function preferredPlatformsOrder(): array;
}
