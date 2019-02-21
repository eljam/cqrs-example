<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Query\Projection;

use Ramsey\Uuid\UuidInterface;

class RoomTripItemView
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @var string
     */
    public $cost;

    /**
     * @var string
     */
    public $paxList;

    /**
     * @var string
     */
    public $tripName;

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
     * @return RoomTripItemView
     */
    public static function fromArray(array $array): self
    {
        $view              = new self();
        $view->id          = $array['id'];
        $view->cost        = $array['cost'];
        $view->paxList     = $array['paxList'];
        $view->tripName    = $array['trip']['name'];
        $view->createdAt   = $array['createdAt'];
        $view->updatedAt   = $array['updatedAt'];

        return $view;
    }
}
