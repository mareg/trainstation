<?php

namespace spec\App\Infrastructure\ArgumentValueResolver;

use App\Infrastructure\ArgumentValueResolver\StationIdArgumentValueResolver;
use App\Trainstation\Station\StationId;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class StationIdArgumentValueResolverSpec extends ObjectBehavior
{
    function let(Request $request, ParameterBag $attributes)
    {
        $request->attributes = $attributes;
    }

    function it_is_ArgumentValueResolver()
    {
        $this->shouldBeAnInstanceOf(ArgumentValueResolverInterface::class);
    }

    function it_supports_StationId(Request $request, ParameterBag $attributes, ArgumentMetadata $argument)
    {
        $attributes->has('station_id')->willReturn(true);
        $argument->getType()->willReturn(StationId::class);

        $this->supports($request, $argument)->shouldBe(true);
    }

    function it_resolves_StationId_from_Request(Request $request, ParameterBag $attributes, ArgumentMetadata $argument)
    {
        $attributes->get('station_id')->willReturn('f4fa1b49-5e95-4260-afa1-d212949b643f');

        $this->resolve($request, $argument)->current()->shouldBeLike(
            StationId::fromString('f4fa1b49-5e95-4260-afa1-d212949b643f')
        );
    }
}
