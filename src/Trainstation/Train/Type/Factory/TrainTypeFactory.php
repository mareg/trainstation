<?php declare(strict_types=1);

namespace App\Trainstation\Train\Type\Factory;

use App\Trainstation\Train\InvalidTrainType;
use App\Trainstation\Train\TrainType;
use App\Trainstation\Train\Type\FastTrainType;
use App\Trainstation\Train\Type\LocalTrainType;
use App\Trainstation\Train\Type\RegionalTrainType;

final class TrainTypeFactory
{
    public static function fromString(string $value): TrainType
    {
        switch ($value) {
            case 'local':
                return new LocalTrainType();
            case 'regional':
                return new RegionalTrainType();
            case 'fast':
                return new FastTrainType();
        }

        throw InvalidTrainType::withString($value);
    }
}
