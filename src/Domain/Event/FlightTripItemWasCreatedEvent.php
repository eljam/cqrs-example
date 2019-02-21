<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\EventDispatcher\Event;

final class FlightTripItemWasCreatedEvent extends Event implements DomainEventInterface
{
    /**
     * @var UuidInterface
     */
    private $tripItemId;

    public function __construct(UuidInterface $tripItemId)
    {
        $this->tripItemId = $tripItemId;
    }

    /**
     * @return string
     */
    public function tripItemId(): string
    {
        return $this->tripItemId->toString();
    }
}
