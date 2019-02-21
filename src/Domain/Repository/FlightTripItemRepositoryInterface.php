<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Repository;

use App\Domain\Model\FlightTripItem;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface TripItemRepositoryInterface.
 */
interface FlightTripItemRepositoryInterface
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
     * @return FlightTripItem
     */
    public function findAndReturnObject(UuidInterface $id): FlightTripItem;

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findAll(int $page, int $limit): array;

    /**
     * @param FlightTripItem $flightTripItem
     */
    public function save(FlightTripItem $flightTripItem): void;

    /**
     * @param FlightTripItem $flightTripItem
     */
    public function remove(FlightTripItem $flightTripItem): void;
}
