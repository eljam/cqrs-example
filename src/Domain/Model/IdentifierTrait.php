<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

/**
 * Trait IdentifierTrait.
 */
trait IdentifierTrait
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @return UuidInterface
     */
    public function id(): UuidInterface
    {
        return $this->id;
    }
}
