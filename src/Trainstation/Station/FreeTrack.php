<?php declare(strict_types=1);

namespace App\Trainstation\Station;

final class FreeTrack
{
    private StationId $stationId;
    private int $trackNumber;

    public function __construct(StationId $stationId, int $trackNumber)
    {
        $this->stationId = $stationId;
        $this->trackNumber = $trackNumber;
    }

    public function stationId(): StationId
    {
        return $this->stationId;
    }

    public function trackNumber(): int
    {
        return $this->trackNumber;
    }
}
