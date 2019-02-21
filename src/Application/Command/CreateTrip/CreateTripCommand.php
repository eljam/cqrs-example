<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Command\CreateTrip;

use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateTripCommand.
 */
final class CreateTripCommand
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;
}
