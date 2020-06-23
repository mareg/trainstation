<?php declare(strict_types=1);

namespace App\Trainstation\Train;

final class InvalidTrainType extends \InvalidArgumentException
{
    public static function withString(string $value): InvalidTrainType
    {
        return new self(
            sprintf('`%s` is not valid Train Type', $value)
        );
    }
}
