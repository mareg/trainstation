<?php declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use App\Trainstation\Station\Station;
use App\Trainstation\Station\StationId;
use App\Trainstation\Station\Track\Tracks;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class StationEntity
{
    private string $uuid;
    private string $name;
    private Collection $tracks;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
    }

    public function asStation(): Station
    {
        $tracks = [];
        /** @var TrackEntity $track */
        foreach ($this->tracks as $track) {
            $tracks[] = $track->asTrack();
        }

        return new Station(StationId::fromString($this->uuid), $this->name, new Tracks($tracks));
    }
}
