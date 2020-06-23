<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Trainstation\Station\FindStation;
use App\Trainstation\Station\FreeTrack;
use App\Trainstation\Station\FreeTrackHandler;
use App\Trainstation\Station\StationId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TrackController
{
    private FindStation $stations;
    private FreeTrackHandler $freeTrackHandler;

    public function __construct(FindStation $stations, FreeTrackHandler $freeTrackHandler)
    {
        $this->stations = $stations;
        $this->freeTrackHandler = $freeTrackHandler;
    }

    /**
     * @Route("/stations/{station_id}/track/{trackNumber}", methods={"GET"})
     */
    public function station(StationId $stationId, int $trackNumber): Response
    {
        $station = $this->stations->findOneByStationId($stationId);

        return new JsonResponse(
            $station->getTrackNumber($trackNumber)
        );
    }

    /**
     * @Route("/stations/{station_id}/track/{trackNumber}", methods={"PUT"})
     */
    public function free(StationId $stationId, int $trackNumber): Response
    {
        ($this->freeTrackHandler)(new FreeTrack($stationId, $trackNumber));

        return new JsonResponse([], 204);
    }
}
