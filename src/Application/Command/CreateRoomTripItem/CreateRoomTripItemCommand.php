<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Command\CreateRoomTripItem;

use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateRoomTripItemCommand.
 */
final class CreateRoomTripItemCommand
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var UuidInterface
     */
    public $tripId;

    /**
     * @var UuidInterface
     */
    public $accommodationId;

    /**
     * @var int
     */
    public $adults;

    /**
     * @var int
     */
    public $children;

    /**
     * @var int
     */
    public $cost;

    /**
     * @var string
     */
    public $paxList;
}
