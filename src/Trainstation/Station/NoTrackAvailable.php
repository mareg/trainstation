<?php declare(strict_types=1);

namespace App\Trainstation\Station;

use App\Trainstation\Train\Train;

final class NoTrackAvailable extends \RuntimeException
{
    public static function forTrain(Train $train): NoTrackAvailable
    {
        return new self(
            sprintf('No track to accommodate `%s` type of train is available.', (string) $train->type()), 409
        );
    }
}
