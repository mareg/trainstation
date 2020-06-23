<?php declare(strict_types=1);

namespace App\Trainstation\Station;

final class StationNotFound extends \RuntimeException
{
    public static function withName(string $name): StationNotFound
    {
        return new self(sprintf("Station named `%s` was not found.", $name), 404);
    }

    public static function withStationId(StationId $stationId): StationNotFound
    {
        return new self(sprintf("Station identified by `%s` was not found.", (string) $stationId), 404);
    }
}
