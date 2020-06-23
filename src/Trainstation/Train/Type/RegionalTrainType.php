<?php declare(strict_types=1);

namespace App\Trainstation\Train\Type;

use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;

final class RegionalTrainType extends AbstractTrainType
{
    public function __construct()
    {
        parent::__construct('regional');
    }

    public function canUseTrack(Track $track): bool
    {
        return $track->hasAnyPlatform() && $track->hasPlatform(Platform::long());
    }

    public function preferredPlatformsOrder(): array
    {
        return [
            Platform::long(),
        ];
    }
}
