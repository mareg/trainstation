<?php

namespace spec\App\Trainstation\Station\Track;

use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\Track\Tracks;
use PhpSpec\ObjectBehavior;

class TracksSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            new Track(1),
            new Track(2),
        ]);
    }

    function it_is_Countable()
    {
        $this->shouldBeAnInstanceOf(\Countable::class);
        $this->count()->shouldReturn(2);
    }

    function it_is_Iterator()
    {
        $this->shouldBeAnInstanceOf(\Iterator::class);

        $this->current()->shouldBeLike(new Track(1));
        $this->valid()->shouldBe(true);
        $this->next();
        $this->valid()->shouldBe(true);
        $this->current()->shouldBeLike(new Track(2));
        $this->next();
        $this->valid()->shouldBe(false);
        $this->rewind();
        $this->current()->shouldBeLike(new Track(1));
    }

    function it_returns_sorted_slice_by_Platforms()
    {
        $track1 = new Track(1, Platform::short());
        $track2 = new Track(2, Platform::long());
        $track3 = new Track(3, Platform::long());
        $track4 = new Track(3, Platform::short());

        $this->beConstructedWith([
            $track1,
            $track2,
            $track3,
            $track4,
        ]);

        $result = $this->sortedSliceByPlatforms([Platform::long()]);

        $result->current()->shouldReturn($track2);
        $result->count()->shouldReturn(2);
    }
}
