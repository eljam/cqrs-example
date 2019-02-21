<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Query\Projection;

use Ramsey\Uuid\UuidInterface;

/**
 * Class TripView.
 */
final class TripView
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var \DateTimeImmutable
     */
    public $createdAt;

    /**
     * @var \DateTimeImmutable
     */
    public $updatedAt;

    /**
     * @param array $array
     *
     * @return TripView
     */
    public static function fromArray(array $array): self
    {
        $view              = new self();
        $view->id          = $array['id'];
        $view->name        = $array['name'];
        $view->description = $array['description'];
        $view->createdAt   = $array['createdAt'];
        $view->updatedAt   = $array['updatedAt'];

        return $view;
    }
}
