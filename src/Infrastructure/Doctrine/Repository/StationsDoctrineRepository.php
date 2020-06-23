<?php declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Infrastructure\Doctrine\Entity\StationEntity;
use App\Trainstation\Station\FindStation;
use App\Trainstation\Station\Station;
use App\Trainstation\Station\StationId;
use App\Trainstation\Station\StationNotFound;
use Doctrine\ORM\EntityManagerInterface;

final class StationsDoctrineRepository implements FindStation
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll(): \Generator
    {
        $repository = $this->entityManager->getRepository(StationEntity::class);

        /** @var StationEntity $entity */
        foreach ($repository->findAll() as $entity) {
            yield $entity->asStation();
        }
    }

    public function findOneByStationId(StationId $stationId): Station
    {
        $repository = $this->entityManager->getRepository(StationEntity::class);

        /** @var StationEntity $entity */
        if ($entity = $repository->find((string) $stationId)) {
            return $entity->asStation();
        }

        throw StationNotFound::withStationId($stationId);
    }

    public function findStationByName(string $name): Station
    {
        $repository = $this->entityManager->getRepository(StationEntity::class);

        /** @var StationEntity $entity */
        if ($entity = $repository->findOneBy(['name' => $name])) {
            return $entity->asStation();
        }

        throw StationNotFound::withName($name);
    }
}
