<?php

namespace spec\App\Trainstation\Station;

use App\Trainstation\Station\StationNotFound;
use PhpSpec\ObjectBehavior;

class StationNotFoundSpec extends ObjectBehavior
{
    function it_is_RuntimeException()
    {
        $this->shouldBeAnInstanceOf(\RuntimeException::class);
    }

    function it_can_be_constructed_with_station_name()
    {
        $this->beConstructedThrough('withName', ['Paddington']);

        $this->getMessage()->shouldReturn("Station named `Paddington` was not found.");
    }
}
