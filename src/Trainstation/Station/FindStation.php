<?php declare(strict_types=1);

namespace App\Trainstation\Station;

interface FindStation
{
    public function findAll(): \Generator;

    public function findOneByStationId(StationId $stationId): Station;

    public function findStationByName(string $name): Station;
}
