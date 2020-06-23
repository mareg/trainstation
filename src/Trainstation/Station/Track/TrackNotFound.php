<?php declare(strict_types=1);

namespace App\Trainstation\Station\Track;

final class TrackNotFound extends \RuntimeException
{
    public static function withTrackNumber(int $trackNumber): TrackNotFound
    {
        return new self(
            sprintf('Track number `%d` was not found.', $trackNumber)
        );
    }
}
