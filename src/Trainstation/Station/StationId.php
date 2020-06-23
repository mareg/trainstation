<?php declare(strict_types=1);

namespace App\Trainstation\Station;

use Ramsey\Uuid\Uuid;

final class StationId implements \JsonSerializable
{
    private Uuid $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public static function fromString(string $value): StationId
    {
        $stationId = new self();
        $stationId->uuid = Uuid::fromString($value);

        return $stationId;
    }

    public function jsonSerialize(): string
    {
        return (string) $this->uuid;
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
