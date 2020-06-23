<?php declare(strict_types=1);

namespace App\Trainstation\Train\Type;

use App\Trainstation\Train\InvalidTrainType;
use App\Trainstation\Train\TrainType;

abstract class AbstractTrainType implements TrainType, \JsonSerializable
{
    protected string $type;

    protected function __construct(string $type)
    {
        $this->type = $type;
    }

    public function jsonSerialize(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
