<?php declare(strict_types=1);

namespace App\Infrastructure\Monolog;

use App\Trainstation\Station\DispatchTrain;
use App\Trainstation\Station\FreeTrack;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\TrackRepository;
use Psr\Log\LoggerInterface;

final class TracksChangesLoggingRepository implements TrackRepository
{
    private TrackRepository $tracks;
    private LoggerInterface $logger;

    public function __construct(TrackRepository $tracks, LoggerInterface $logger)
    {
        $this->tracks = $tracks;
        $this->logger = $logger;
    }

    public function dispatchTrainForTrack(DispatchTrain $dispatchTrain, Track $track): void
    {
        $this->logger->info(
            sprintf(
                '%s: Train %s was dispatched to track %d',
                (string) $dispatchTrain->stationId(),
                $dispatchTrain->train()->number(),
                $track->number()
            )
        );

        $this->tracks->dispatchTrainForTrack($dispatchTrain, $track);
    }

    public function dispatchTrainFromTrack(FreeTrack $freeTrack): void
    {
        $this->logger->info(
            sprintf(
                '%s: Train left the track %d',
                (string) $freeTrack->stationId(),
                $freeTrack->trackNumber()
            )
        );

        $this->tracks->dispatchTrainFromTrack($freeTrack);
    }
}
