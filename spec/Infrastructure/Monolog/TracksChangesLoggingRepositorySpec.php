<?php

namespace spec\App\Infrastructure\Monolog;

use App\Infrastructure\Monolog\TracksChangesLoggingRepository;
use App\Trainstation\Station\DispatchTrain;
use App\Trainstation\Station\FreeTrack;
use App\Trainstation\Station\StationId;
use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\TrackRepository;
use App\Trainstation\Train\Train;
use App\Trainstation\Train\Type\FastTrainType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class TracksChangesLoggingRepositorySpec extends ObjectBehavior
{
    function let(TrackRepository $tracks, LoggerInterface $logger)
    {
        $this->beConstructedWith($tracks, $logger);
    }

    function it_decorates_TrackRepository(TrackRepository $tracks)
    {
        $this->shouldBeAnInstanceOf(TrackRepository::class);
    }

    function it_logs_dispatched_train(TrackRepository $tracks, LoggerInterface $logger)
    {
        $dispatchTrain = new DispatchTrain(new StationId(), new Train('IC3167', new FastTrainType()));
        $track = new Track(1, Platform::long());

        $tracks->dispatchTrainForTrack($dispatchTrain, $track)->shouldBeCalled();
        $logger->info(Argument::type('string'))->shouldBeCalled();

        $this->dispatchTrainForTrack($dispatchTrain, $track);
    }

    function it_logs_released_track(TrackRepository $tracks, LoggerInterface $logger)
    {
        $freeTrack = new FreeTrack(new StationId(), 3);

        $tracks->dispatchTrainFromTrack($freeTrack)->shouldBeCalled();
        $logger->info(Argument::type('string'))->shouldBeCalled();

        $this->dispatchTrainFromTrack($freeTrack);
    }
}
