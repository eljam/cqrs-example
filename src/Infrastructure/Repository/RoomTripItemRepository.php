<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Repository;

use App\Domain\Model\RoomTripItem;
use App\Domain\Repository\RoomTripItemRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class RoomTripItemRepository implements RoomTripItemRepositoryInterface
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
     * @return RoomTripItem
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAndReturnObject(UuidInterface $id): RoomTripItem
    {
        return $this->entityManager->createQueryBuilder()
            ->select('rt')
            ->from(RoomTripItem::class, 'rt')
            ->where('rt.id = :id')
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
            ->select('rt', 'ac', 'tr')
            ->from(RoomTripItem::class, 'rt')
            ->innerJoin('rt.accommodation', 'ac')
            ->innerJoin('rt.trip', 'tr')
            ->where('rt.id = :id')
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
            ->select('rt', 'ac', 'tr')
            ->from(RoomTripItem::class, 'rt')
            ->innerJoin('rt.accommodation', 'ac')
            ->innerJoin('rt.trip', 'tr')
            ->orderBy('rt.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(RoomTripItem $roomTripItem): void
    {
        $this->entityManager->persist($roomTripItem);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(RoomTripItem $roomTripItem): void
    {
        $this->entityManager->remove($roomTripItem);
        $this->entityManager->flush();
    }
}
