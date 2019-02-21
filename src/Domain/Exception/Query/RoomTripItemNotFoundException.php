<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Exception\Query;

use App\Domain\Shared\Query\NotFoundException;

final class RoomTripItemNotFoundException extends NotFoundException
{
    /**
     * @param string $id
     *
     * @return RoomTripItemNotFoundException
     */
    public static function withId(string $id): self
    {
        return new self(\sprintf('A room trip item with Id "%s" does not exist.', $id));
    }
}
