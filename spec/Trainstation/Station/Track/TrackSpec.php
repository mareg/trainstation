<?php

namespace spec\App\Trainstation\Station\Track;

use App\Trainstation\Station\Track\InvalidTrainTypeDispatched;
use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\TrackIsAlreadyOccupied;
use App\Trainstation\Train\Train;
use App\Trainstation\Train\Type\LocalTrainType;
use App\Trainstation\Train\Type\RegionalTrainType;
use PhpSpec\ObjectBehavior;

class TrackSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(2);
    }

    function it_has_no_platform_by_default()
    {
        $this->hasAnyPlatform()->shouldBe(false);
    }

    function it_tells_that_it_has_a_platform()
    {
        $this->beConstructedWith(2, Platform::short());

        $this->hasPlatform(Platform::short())->shouldBe(true);
        $this->hasPlatform(Platform::long())->shouldBe(false);
    }

    function it_can_have_train_dispatched()
    {
        $this->beConstructedWith(2, Platform::long());

        $train = new Train(2, new LocalTrainType());

        $this->dispatchTrain($train);
    }

    function it_tells_track_is_occupied()
    {
        $this->beConstructedWith(2, Platform::long());

        $train = new Train(2, new LocalTrainType());

        $this->isOccupied()->shouldBe(false);

        $this->dispatchTrain($train);

        $this->isOccupied()->shouldBe(true);
    }

    function it_throws_TrackIsOccupied_exception_if_second_train_is_dispatched()
    {
        $this->beConstructedWith(2, Platform::long());

        $localTrain = new Train(2, new LocalTrainType());

        $this->dispatchTrain($localTrain);

        $regionalTrain = new Train(2, new RegionalTrainType());

        $this->shouldThrow(new TrackIsAlreadyOccupied())->duringDispatchTrain($regionalTrain);
    }

    function it_can_be_freed_by_departing_train()
    {
        $this->beConstructedWith(2, Platform::long());

        $localTrain = new Train(2, new LocalTrainType());

        $this->dispatchTrain($localTrain);

        $this->free();

        $regionalTrain = new Train(2, new RegionalTrainType());

        $this->dispatchTrain($regionalTrain);
    }

    function it_throws_InvalidTrainTypeDispatched_if_wrong_train_is_dispatched()
    {
        $this->beConstructedWith(2, Platform::short());

        $regionalTrain = new Train(2, new RegionalTrainType());

        $this->shouldThrow(new InvalidTrainTypeDispatched())->duringDispatchTrain($regionalTrain);
    }
}
