<?php declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Train\Train;

class TrackEntity
{
    private string $uuid;

    private int $trackNumber;

    private ?string $platform = null;

    private ?string $train = null;

    private StationEntity $station;

    public function asTrack()
    {
        return new Track(
            $this->trackNumber,
            $this->platform ? Platform::fromString($this->platform) : null,
            $this->train ? Train::fromJson($this->train) : null
        );
    }
}
