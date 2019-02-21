<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Repository;

use App\Domain\Model\Accommodation;
use App\Domain\Repository\AccommodationRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class AccommodationRepository implements AccommodationRepositoryInterface
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
     * @return Accommodation
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAndReturnObject(UuidInterface $id): Accommodation
    {
        return $this->entityManager->createQueryBuilder()
            ->select('ac')
            ->from(Accommodation::class, 'ac')
            ->where('ac.id = :id')
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
            ->select('ac')
            ->from(Accommodation::class, 'ac')
            ->where('ac.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(int $page, int $limit = 30): array
    {
        $offset = ($page - 1) * $limit;

        return $this->entityManager->createQueryBuilder()
            ->select('ac')
            ->from(Accommodation::class, 'ac')
            ->orderBy('ac.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Accommodation $accommodation): void
    {
        $this->entityManager->persist($accommodation);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Accommodation $accommodation): void
    {
        $this->entityManager->remove($accommodation);
        $this->entityManager->flush();
    }
}
