<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Repository;

use App\Domain\Model\Trip;
use App\Domain\Repository\TripRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class TripRepository.
 */
final class TripRepository implements TripRepositoryInterface
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
     * @return Trip
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAndReturnObject(UuidInterface $id): Trip
    {
        return $this->entityManager->createQueryBuilder()
            ->select('trip')
            ->from(Trip::class, 'trip')
            ->where('trip.id = :id')
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
            ->select('trip')
            ->from(Trip::class, 'trip')
            ->where('trip.id = :id')
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
            ->select('trip')
            ->from(Trip::class, 'trip')
            ->orderBy('trip.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Trip $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Trip $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
