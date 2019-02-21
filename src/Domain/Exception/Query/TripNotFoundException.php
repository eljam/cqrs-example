<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Exception\Query;

use App\Domain\Shared\Query\NotFoundException;

final class TripNotFoundException extends NotFoundException
{
    /**
     * @param string $id
     *
     * @return TripNotFoundException
     */
    public static function withId(string $id): self
    {
        return new self(\sprintf('A trip with Id "%s" does not exist.', $id));
    }
}
