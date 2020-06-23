<?php declare(strict_types=1);

namespace App\Trainstation\Station\Track;

use App\Trainstation\Train\TrainType;

final class Tracks implements \Countable, \Iterator, \JsonSerializable
{
    /**
     * @var Track[]
     */
    private array $tracks = [];

    private int $position;

    public function __construct(array $tracks)
    {
        foreach ($tracks as $track) {
            if ($track instanceof Track) {
                $this->tracks[] = $track;
            }
        }

        $this->position = 0;
    }

    public function sortedSliceByPlatforms(array $platforms = []): Tracks
    {
        $tracks = [];
        foreach ($platforms as $platform) {
            foreach ($this->tracks as $track) {
                if (($platform instanceof Platform && $track->hasPlatform($platform)) || (!$platform && !$track->hasAnyPlatform())) {
                    $tracks[] = $track;
                }
            }
        }

        return new Tracks($tracks);
    }

    public function count(): int
    {
        return count($this->tracks);
    }

    public function current(): Track
    {
        return $this->tracks[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return array_key_exists($this->position, $this->tracks);
    }

    public function jsonSerialize(): array
    {
        return $this->tracks;
    }
}
