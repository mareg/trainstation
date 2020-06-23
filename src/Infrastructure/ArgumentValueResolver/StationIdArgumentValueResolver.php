<?php declare(strict_types=1);

namespace App\Infrastructure\ArgumentValueResolver;

use App\Trainstation\Station\StationId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class StationIdArgumentValueResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $request->attributes->has('station_id') && StationId::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield StationId::fromString($request->attributes->get('station_id'));
    }
}
