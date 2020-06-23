<?php declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Trainstation\Station\DispatchTrain;
use App\Trainstation\Station\FreeTrack;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;

final class TrackDoctrineRepository implements TrackRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function dispatchTrainForTrack(DispatchTrain $dispatchTrain, Track $track): void
    {
        $sql = sprintf("
            UPDATE tracks SET train = '%s' WHERE station_id = '%s' AND track_number = %d
        ", json_encode($dispatchTrain->train()), (string) $dispatchTrain->stationId(), $track->number());

        $this->entityManager->getConnection()->exec($sql);
    }

    public function dispatchTrainFromTrack(FreeTrack $freeTrack): void
    {
        $sql = sprintf("
            UPDATE tracks SET train = NULL WHERE station_id = '%s' AND track_number = %d
        ", (string) $freeTrack->stationId(), $freeTrack->trackNumber());

        $this->entityManager->getConnection()->exec($sql);
    }
}
