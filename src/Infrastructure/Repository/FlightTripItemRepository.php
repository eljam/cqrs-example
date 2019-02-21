<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Repository;

use App\Domain\Model\FlightTripItem;
use App\Domain\Repository\FlightTripItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class FlightTripItemRepository implements FlightTripItemRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UuidInterface $id
     *
     * @return FlightTripItem
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAndReturnObject(UuidInterface $id): FlightTripItem
    {
        return $this->entityManager->createQueryBuilder()
            ->select('ft')
            ->from(FlightTripItem::class, 'ft')
            ->where('ft.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function find(UuidInterface $id): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('ft')
            ->from(FlightTripItem::class, 'ft')
            ->where('ft.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(int $page, int $limit = 30): array
    {
        $offset = ($page - 1) * $limit;

        return $this->entityManager->createQueryBuilder()
            ->select('ft')
            ->from(FlightTripItem::class, 'ft')
            ->orderBy('ft.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(FlightTripItem $flightTripItem): void
    {
        $this->entityManager->persist($flightTripItem);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(FlightTripItem $flightTripItem): void
    {
        $this->entityManager->remove($flightTripItem);
        $this->entityManager->flush();
    }
}
