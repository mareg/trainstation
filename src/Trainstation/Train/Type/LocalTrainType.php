<?php declare(strict_types=1);

namespace App\Trainstation\Train\Type;

use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Train\TrainType;

final class LocalTrainType extends AbstractTrainType
{
    public function __construct()
    {
        parent::__construct('local');
    }

    public function canUseTrack(Track $track): bool
    {
        return $track->hasAnyPlatform();
    }

    public function preferredPlatformsOrder(): array
    {
        return [
            Platform::short(),
            Platform::long(),
        ];
    }
}
