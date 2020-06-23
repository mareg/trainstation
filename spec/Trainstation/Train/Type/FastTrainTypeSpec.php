<?php

namespace spec\App\Trainstation\Train\Type;

use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Train\TrainType;
use PhpSpec\ObjectBehavior;

class FastTrainTypeSpec extends ObjectBehavior
{
    function it_is_TrainType()
    {
        $this->shouldBeAnInstanceOf(TrainType::class);
    }

    function it_can_use_a_track_without_platform()
    {
        $track = new Track(2);

        $this->canUseTrack($track)->shouldBe(true);
    }

    function it_can_use_a_track_with_a_long_platform()
    {
        $track = new Track(3, Platform::long());

        $this->canUseTrack($track)->shouldBe(true);
    }

    function it_cannot_use_a_track_with_a_short_platform()
    {
        $track = new Track(3, Platform::short());

        $this->canUseTrack($track)->shouldBe(false);
    }
}
