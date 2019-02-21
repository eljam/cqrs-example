<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Command\CreateFlightTripItem;

use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateTripCommand.
 */
final class CreateFlightTripItemCommand
{
    /**
     * @var UuidInterface
     */
    public $tripId;

    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $passport;

    /**
     * @var int
     */
    public $cost;

    /**
     * @var string
     */
    public $paxList;
}
