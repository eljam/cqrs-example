<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Repository;

use App\Domain\Model\Accommodation;
use Ramsey\Uuid\UuidInterface;

interface AccommodationRepositoryInterface
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
     * @return Accommodation
     */
    public function findAndReturnObject(UuidInterface $id): Accommodation;

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function findAll(int $page, int $limit): array;

    /**
     * @param Accommodation $accommodation
     */
    public function save(Accommodation $accommodation): void;

    /**
     * @param Accommodation $accommodation
     */
    public function remove(Accommodation $accommodation): void;
}
