<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

/**
 * Class Accommodation.
 */
class Accommodation
{
    use TimeTrait;
    use IdentifierTrait;

    /**
     * @var AccommodationType
     */
    private $accommodationType;

    /**
     * @var string|null the name of the item
     */
    private $name;

    /**
     * @var string|null
     */
    private $shortDescription;

    /**
     * @var string|null a description of the item
     */
    private $description;

    /**
     * @var int|null
     */
    private $rating;

    /**
     * @var string|null physical address of the item
     */
    private $address;

    /**
     * @var string|null the telephone number
     */
    private $phoneNumber;

    public function __construct(
        UuidInterface $id,
        $name,
        $shortDescription,
        $description,
        $rating,
        $address,
        $phoneNumber
    ) {
        $this->id               = $id;
        $this->name             = $name;
        $this->shortDescription = $shortDescription;
        $this->description      = $description;
        $this->rating           = $rating;
        $this->address          = $address;
        $this->phoneNumber      = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function shortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function rating(): ?int
    {
        return $this->rating;
    }

    /**
     * @return string|null
     */
    public function address(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function phoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @return AccommodationType
     */
    public function accommodationType(): AccommodationType
    {
        return $this->accommodationType;
    }

    /**
     * @param AccommodationType $accommodationType
     *
     * @return Accommodation
     */
    public function addAccommodationType(AccommodationType $accommodationType): self
    {
        $this->accommodationType = $accommodationType;

        return $this;
    }
}
