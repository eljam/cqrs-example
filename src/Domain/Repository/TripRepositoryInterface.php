<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Repository;

use App\Domain\Model\Trip;
use Ramsey\Uuid\UuidInterface;

interface TripRepositoryInterface
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
     * @return Trip
     */
    public function findAndReturnObject(UuidInterface $id): Trip;

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findAll(int $page, int $limit): array;

    /**
     * @param Trip $trip
     */
    public function save(Trip $trip): void;

    /**
     * @param Trip $trip
     */
    public function remove(Trip $trip): void;
}
