<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use App\Domain\Event\FlightTripItemWasCreatedEvent;
use BornFree\TacticianDomainEvent\Recorder\EventRecorderCapabilities;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

/**
 * Class AccommodationTripItem.
 */
class FlightTripItem extends TripItem
{
    use EventRecorderCapabilities;

    /**
     * @var string
     */
    private $passport;

    /**
     * FlightTripItem constructor.
     *
     * @param UuidInterface $id
     * @param UuidInterface $tripId
     * @param string        $passport
     * @param int           $cost
     * @param string        $paxList
     */
    public function __construct(UuidInterface $id, UuidInterface $tripId, string $passport, int $cost, string $paxList)
    {
        $this->validate($id, $tripId, $passport, $cost, $paxList);
        $this->cost     = $cost;
        $this->passport = $passport;
        $this->paxList  = $paxList;
        $this->id       = $id;

        $this->record(new FlightTripItemWasCreatedEvent($this->id));
    }

    /**
     * @param UuidInterface $id
     * @param UuidInterface $tripId
     * @param string        $passport
     * @param int           $cost
     * @param string        $paxList
     *
     * @return FlightTripItem
     */
    public static function create(
        UuidInterface $id,
        UuidInterface $tripId,
        string $passport,
        int $cost,
        string $paxList
    ): self {
        return new self($id, $tripId, $passport, $cost, $paxList);
    }

    /**
     * @return string
     */
    public function passport(): ?string
    {
        return $this->passport;
    }

    private function validate(UuidInterface $id, UuidInterface $tripId, string $passport, int $cost, string $paxList)
    {
        Assert::notEmpty($passport);
    }
}
