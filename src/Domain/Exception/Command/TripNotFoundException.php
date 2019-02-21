<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Exception\Command;

use App\Domain\Shared\Command\NotFoundException;

/**
 * Class AccommodationNotFoundException.
 */
class TripNotFoundException extends NotFoundException
{
    /**
     * @param string $id
     *
     * @return TripNotFoundException
     */
    public static function withId(string $id): self
    {
        return new self(\sprintf('An trip with Id "%s" does not exist.', $id));
    }
}
