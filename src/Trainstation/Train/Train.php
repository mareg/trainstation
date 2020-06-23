<?php declare(strict_types=1);

namespace App\Trainstation\Train;

use App\Trainstation\Station\Track\Track;
use App\Trainstation\Train\Type\Factory\TrainTypeFactory;

final class Train implements \JsonSerializable
{
    private string $name;
    private TrainType $type;

    public function __construct(string $name, TrainType $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function canUseTrack(Track $track): bool
    {
        return $this->type->canUseTrack($track);
    }

    public function number(): string
    {
        return $this->name;
    }

    public function type(): TrainType
    {
        return $this->type;
    }

    public function preferredPlatformsOrder(): array
    {
        return $this->type->preferredPlatformsOrder();
    }

    public static function fromJson(string $json): Train
    {
        $data = json_decode($json, true);

        foreach (['number', 'type'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidTrainData("Expected a key `{$key}`, but didn't find it.");
            }
        }

        try {
            return new Train($data['number'], TrainTypeFactory::fromString($data['type']));
        } catch (InvalidTrainType $exception) {
            throw new InvalidTrainData($exception->getMessage());
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->name,
            'type' => $this->type,
        ];
    }
}
