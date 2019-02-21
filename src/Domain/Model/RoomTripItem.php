<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use App\Domain\Event\RoomTripItemWasCreatedEvent;
use BornFree\TacticianDomainEvent\Recorder\EventRecorderCapabilities;
use Ramsey\Uuid\UuidInterface;

/**
 * Class AccommodationTripItem.
 */
class RoomTripItem extends TripItem
{
    use EventRecorderCapabilities;

    /**
     * @var Accommodation
     */
    private $accommodation;

    /**
     * @var int
     */
    private $adults;

    /**
     * @var int
     */
    private $children;

    /**
     * RoomTripItem constructor.
     *
     * @param UuidInterface $id
     * @param int           $adults
     * @param int           $children
     * @param string        $paxList
     * @param int           $cost
     * @param Accommodation $accommodation
     * @param Trip          $trip
     */
    public function __construct(
        UuidInterface $id,
        int $adults,
        int $children,
        string $paxList,
        int $cost,
        Accommodation $accommodation,
        Trip $trip
    ) {
        $this->adults                 = $adults;
        $this->children               = $children;
        $this->paxList                = $paxList;
        $this->id                     = $id;
        $this->cost                   = $cost;
        $this->accommodation          = $accommodation;
        $this->trip                   = $trip;

        $this->record(new RoomTripItemWasCreatedEvent($this->id()));
    }

    /**
     * @param UuidInterface $id
     * @param int           $adults
     * @param int           $children
     * @param string        $paxList
     * @param int           $cost
     * @param Accommodation $accommodation
     * @param Trip          $trip
     *
     * @return RoomTripItem
     */
    public static function create(
        UuidInterface $id,
        int $adults,
        int $children,
        string $paxList,
        int $cost,
        Accommodation $accommodation,
        Trip $trip
    ): self {
        return new self(
            $id,
            $adults,
            $children,
            $paxList,
            $cost,
            $accommodation,
            $trip
        );
    }

    /**
     * @param Accommodation $accommodation
     *
     * @return RoomTripItem
     */
    public function addAccommodation(Accommodation $accommodation): self
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    /**
     * @return int
     */
    public function adults()
    {
        return $this->adults;
    }

    /**
     * @return int
     */
    public function children()
    {
        return $this->children;
    }
}
