<?php declare(strict_types=1);

namespace App\Trainstation\Station;

use App\Trainstation\Train\Train;

final class DispatchTrain
{
    private StationId $stationId;
    private Train $train;

    public function __construct(StationId $stationId, Train $train)
    {
        $this->stationId = $stationId;
        $this->train = $train;
    }

    public function stationId(): StationId
    {
        return $this->stationId;
    }

    public function train(): Train
    {
        return $this->train;
    }
}
