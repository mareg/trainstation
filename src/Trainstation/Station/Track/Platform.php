<?php declare(strict_types=1);

namespace App\Trainstation\Station\Track;

final class Platform implements \JsonSerializable
{
    private string $type;

    private function __construct(string $value)
    {
        $this->isValidStringValue($value);

        $this->type = $value;
    }

    private function isValidStringValue(string $value): void
    {
        if (!in_array($value, ['short', 'long'])) {
            throw new \InvalidArgumentException(
                sprintf("`%s` is not valid Platform type.", $value)
            );
        }
    }

    public static function fromString(string $value): Platform
    {
        return new self($value);
    }

    public static function short(): Platform
    {
        return new self('short');
    }

    public static function long(): Platform
    {
        return new self('long');
    }

    public function jsonSerialize(): string
    {
        return $this->type;
    }
}
