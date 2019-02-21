<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

/**
 * Class AccommodationType.
 */
class AccommodationType
{
    use TimeTrait;
    use IdentifierTrait;

    /**
     * @var string|null the name of the item
     */
    private $name;

    /**
     * AccommodationType constructor.
     *
     * @param UuidInterface $id
     * @param string        $name
     */
    public function __construct(UuidInterface $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }
}
