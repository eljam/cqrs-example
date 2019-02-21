<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Repository;

use App\Domain\Model\RoomTripItem;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface RoomTripItemRepositoryInterface.
 */
interface RoomTripItemRepositoryInterface
{
    /**
     * @param UuidInterface $id
     *
     * @return array
     */
    public function find(UuidInterface $id): array;

    /**
     * @param UuidInterface $id
     *
     * @return RoomTripItem
     */
    public function findAndReturnObject(UuidInterface $id): RoomTripItem;

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findAll(int $page, int $limit): array;

    /**
     * @param RoomTripItem $roomTripItem
     */
    public function save(RoomTripItem $roomTripItem): void;

    /**
     * @param RoomTripItem $roomTripItem
     */
    public function remove(RoomTripItem $roomTripItem): void;
}
