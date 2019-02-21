<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use BornFree\TacticianDomainEvent\Recorder\ContainsRecordedEvents;

/**
 * Class TripItem.
 */
abstract class TripItem implements ContainsRecordedEvents
{
    use TimeTrait;
    use IdentifierTrait;

    /**
     * @var string
     */
    protected $paxList;

    /**
     * @var int
     */
    protected $cost;

    /**
     * @var string
     */
    protected $bookingState = 'pending';

    /**
     * @var Trip
     */
    protected $trip;

    /**
     * @param Trip $trip
     */
    public function addTrip(Trip $trip)
    {
        $this->trip = $trip;
    }

    /**
     * @return string
     */
    public function bookingState(): string
    {
        return (string) $this->bookingState;
    }

    /**
     * @return int
     */
    public function cost(): ?int
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function paxList(): ?string
    {
        return $this->paxList;
    }
}
