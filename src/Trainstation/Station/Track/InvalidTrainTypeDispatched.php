<?php declare(strict_types=1);

namespace App\Trainstation\Station\Track;

final class InvalidTrainTypeDispatched extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid train type dispatched', 400);
    }
}
