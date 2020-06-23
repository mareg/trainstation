<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Trainstation\Station\FindStation;
use App\Trainstation\Station\StationId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class StationController
{
    private FindStation $stations;

    public function __construct(FindStation $stations)
    {
        $this->stations = $stations;
    }

    /**
     * @Route("/stations", methods={"GET"})
     */
    public function list(): Response
    {
        return new JsonResponse(
            iterator_to_array($this->stations->findAll())
        );
    }

    /**
     * @Route("/stations/{stationId}", methods={"GET"})
     */
    public function station(string $stationId): Response
    {
        return new JsonResponse(
            $this->stations->findOneByStationId(StationId::fromString($stationId))
        );
    }
}
