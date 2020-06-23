<?php declare(strict_types=1);

namespace App\Trainstation\Station\Track;

final class TrackIsAlreadyOccupied extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Track is already occupied", 409);
    }
}
