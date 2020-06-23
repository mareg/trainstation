<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Infrastructure\Factory\TrainFactory;
use App\Trainstation\Station\DispatchTrain;
use App\Trainstation\Station\DispatchTrainHandler;
use App\Trainstation\Station\NoTrackAvailable;
use App\Trainstation\Station\StationId;
use App\Trainstation\Station\Track\InvalidTrainTypeDispatched;
use App\Trainstation\Train\InvalidTrainData;
use App\Trainstation\Train\Train;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DispatchTrainController
{
    private DispatchTrainHandler $dispatchTrainHandler;

    public function __construct(DispatchTrainHandler $dispatchTrainHandler)
    {
        $this->dispatchTrainHandler = $dispatchTrainHandler;
    }

    /**
     * @Route("/stations/{station_id}", methods={"POST"})
     */
    public function dispatch(StationId $stationId, Request $request): Response
    {
        try {
            $train = Train::fromJson($request->getContent());
        } catch (InvalidTrainData $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 400);
        }

        try {
            $track = ($this->dispatchTrainHandler)(new DispatchTrain($stationId, $train));
        } catch (NoTrackAvailable $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode());
        } catch (InvalidTrainTypeDispatched $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode());
        }

        return new RedirectResponse(
            sprintf('/stations/%s/track/%d', (string) $stationId, $track->number()), 201
        );
    }
}
