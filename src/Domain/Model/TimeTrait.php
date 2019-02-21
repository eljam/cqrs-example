<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Model;

/**
 * Trait TimeTrait.
 */
trait TimeTrait
{
    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function updatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
