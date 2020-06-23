<?php declare(strict_types=1);

namespace App\Infrastructure\InMemory;

use App\Trainstation\Station\FindStation;
use App\Trainstation\Station\Station;
use App\Trainstation\Station\StationId;
use App\Trainstation\Station\StationNotFound;

final class StationsInMemoryRepository implements FindStation
{
    private array $stations = [];

    public function findAll(): \Generator
    {
        foreach ($this->stations as $station) {
            yield $station;
        }
    }

    public function findOneByStationId(StationId $stationId): Station
    {
        $key = (string) $stationId;
        if (array_key_exists($key, $this->stations)) {
            return $this->stations[$key];
        }

        throw StationNotFound::withStationId($stationId);
    }

    public function findStationByName(string $name): Station
    {
        /** @var Station $station */
        foreach ($this->stations as $station) {
            if ($station->name() === $name) {
                return $station;
            }
        }

        throw StationNotFound::withName($name);
    }

    public function persist(Station $station): void
    {
        $this->stations[(string) $station->stationId()] = $station;
    }
}
