<?php declare(strict_types=1);

namespace App\Tests\Behat;

use App\Trainstation\Station\FindStation;
use App\Trainstation\Station\Station;
use App\Trainstation\Station\StationId;
use App\Trainstation\Station\Track\Platform;
use App\Trainstation\Station\Track\Track;
use App\Trainstation\Station\Track\Tracks;
use App\Trainstation\Train\Train;
use App\Trainstation\Train\Type\LocalTrainType;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class TrainstationContext implements Context
{
    private KernelInterface $kernel;

    private ?Response $response = null;

    private ?StationId $stationId = null;

    private FindStation $stations;

    public function __construct(KernelInterface $kernel, FindStation $stations)
    {
        $this->kernel = $kernel;
        $this->stations = $stations;
    }

    /**
     * @Given station named :stationName has tracks
     * @Given station named :stationName has tracks with trains
     */
    public function stationNamedHasTracks(string $stationName, TableNode $table)
    {
        $tracks = [];
        foreach ($table as $row) {
            $platform = $row['platform'] ? Platform::fromString($row['platform']) : null;
            $train = isset($row['train']) && $row['train'] ? new Train($row['train'], new LocalTrainType()) : null;

            $tracks[] = new Track((int) $row['track number'], $platform, $train);
        }

        $station = Station::namedWithTracks($stationName, new Tracks($tracks));

        $this->stations->persist($station);

        $this->stationId = $station->stationId();
    }

    /**
     * @When I dispatch a :trainType train number :trainNumber
     */
    public function iDispatchALocalTrainNumberL(string $trainType, string $trainNumber)
    {
        $uri = sprintf('/stations/%s', (string) $this->stationId);

        $payload = json_encode(['type' => $trainType, 'number' => $trainNumber]);

        $this->response = $this->kernel->handle(Request::create($uri, 'POST', [], [], [], [], $payload));
    }

    /**
     * @Then train number :trainNumber should occupy track number :trackNumber
     */
    public function trainNumberLShouldOccupyTrackNumber(string $trainNumber, int $trackNumber)
    {
        $this->assertResponseIsNotNull();
        $this->assertResponseStatusCode(201);

        if (!$this->response->headers->has('location')) {
            throw new \RuntimeException('Expected new resource location');
        }

        $uri = sprintf('/stations/%s/track/%d', (string) $this->stationId, $trackNumber);
        Assert::assertEquals($uri, $this->response->headers->get('location'));

        $station = $this->stations->findOneByStationId($this->stationId);
        $track = $station->getTrackNumber($trackNumber);

        Assert::assertEquals($trainNumber, $track->train()->number());
    }


    /**
     * @Then I should be notified of no available tracks
     */
    public function iShouldBeNotifiedOfNoAvailableTracks()
    {
        $this->assertResponseIsNotNull();
        $this->assertResponseStatusCode(409);

        $response = json_decode($this->response->getContent(), true);

        Assert::assertStringStartsWith('No track to accommodate', $response['error']);
    }

    /**
     * @When train frees track number :trackNumber
     */
    public function trainFreesTrackNumber(int $trackNumber)
    {
        $uri = sprintf('/stations/%s/track/%d', (string) $this->stationId, $trackNumber);

        $this->response = $this->kernel->handle(Request::create($uri, 'PUT'));

        $station = $this->stations->findOneByStationId($this->stationId);
        $track = $station->getTrackNumber($trackNumber);

        Assert::assertNull($track->train());
    }

    /**
     * @Then track number :trackNumber should not be occupied
     */
    public function trackNumberShouldNotBeOccupied(int $trackNumber)
    {
        $this->assertResponseIsNotNull();
        $this->assertResponseStatusCode(204);
    }

    private function assertResponseIsNotNull(): void
    {
        Assert::assertNotNull($this->response, 'Expected to get a response, got none.');
    }

    private function assertResponseStatusCode(int $expectedStatusCode): void
    {
        $message = sprintf('Expected %d, got %d', $expectedStatusCode, $this->response->getStatusCode());
        Assert::assertEquals($expectedStatusCode, $this->response->getStatusCode(), $message);
    }
}
