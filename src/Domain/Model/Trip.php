<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use App\Domain\Event\TripWasCreatedEvent;
use BornFree\TacticianDomainEvent\Recorder\ContainsRecordedEvents;
use BornFree\TacticianDomainEvent\Recorder\EventRecorderCapabilities;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Trip.
 */
class Trip implements ContainsRecordedEvents
{
    use TimeTrait;
    use EventRecorderCapabilities;
    use IdentifierTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var ArrayCollection
     */
    private $tripItems;

    public function __construct(UuidInterface $id, string $name, string $description)
    {
        $this->id          = $id;
        $this->name        = $name;
        $this->description = $description;
        $this->tripItems   = new ArrayCollection();

        $this->record((new TripWasCreatedEvent($this->id(), $this->name())));
    }

    /**
     * @return string
     */
    public function __toString(): ?string
    {
        return (string) $this->name();
    }

    /**
     * @param UuidInterface $id
     * @param string        $name
     * @param string        $description
     *
     * @return Trip
     */
    public static function create(UuidInterface $id, string $name, string $description): self
    {
        return new self($id, $name, $description);
    }

    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return (string) $this->description;
    }
}
