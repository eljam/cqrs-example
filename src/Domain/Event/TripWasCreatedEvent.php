<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TripWasCreatedEvent.
 */
final class TripWasCreatedEvent extends Event implements DomainEventInterface
{
    /**
     * @var UuidInterface
     */
    private $tripId;

    /**
     * @var string
     */
    private $tripName;

    public function __construct(UuidInterface $tripId, string $tripName)
    {
        $this->tripId  = $tripId;
        $this->tripName= $tripName;
    }

    /**
     * @return string
     */
    public function tripId(): string
    {
        return $this->tripId->toString();
    }

    /**
     * @return string
     */
    public function tripName(): string
    {
        return $this->tripName;
    }
}
