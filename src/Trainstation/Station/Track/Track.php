<?php declare(strict_types=1);

namespace App\Trainstation\Station\Track;

use App\Trainstation\Train\Train;

final class Track implements \JsonSerializable
{
    private int $trackNumber;
    private ?Platform $platform;
    private ?Train $train;

    public function __construct(int $trackNumber, Platform $platform = null, Train $train = null)
    {
        $this->trackNumber = $trackNumber;
        $this->platform = $platform;
        $this->train = $train;
    }

    public function number(): int
    {
        return $this->trackNumber;
    }

    public function train(): ?Train
    {
        return $this->train;
    }

    public function hasAnyPlatform(): bool
    {
        return $this->platform instanceof Platform;
    }

    public function hasPlatform(Platform $platform): bool
    {
        return $this->platform == $platform;
    }

    public function dispatchTrain(Train $train): void
    {
        if ($this->isOccupied()) {
            throw new TrackIsAlreadyOccupied();
        }

        if (!$train->canUseTrack($this)) {
            throw new InvalidTrainTypeDispatched();
        }

        $this->train = $train;
    }

    public function isOccupied(): bool
    {
        return $this->train instanceof Train;
    }

    public function free(): void
    {
        $this->train = null;
    }

    public function jsonSerialize(): array
    {
        return [
            'track_number' => $this->trackNumber,
            'platform' => $this->platform ?: null,
            'is_occupied' => $this->isOccupied(),
            'train' => $this->train ?: null,
        ];
    }
}
