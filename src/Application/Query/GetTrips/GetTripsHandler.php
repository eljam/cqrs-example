<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Query\GetTrips;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Repository\TripRepositoryInterface;

/**
 * Class GetTripsHandler.
 */
final class GetTripsHandler implements QueryHandlerInterface
{
    /**
     * @var TripRepositoryInterface
     */
    private $tripRepository;

    /**
     * GetTripsHandler constructor.
     *
     * @param TripRepositoryInterface $tripRepository
     */
    public function __construct(TripRepositoryInterface $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
     * @param GetTripsQuery $query
     *
     * @return array
     */
    public function __invoke(GetTripsQuery $query): array
    {
        return $this->tripRepository->findAll($query->page, $query->limit);
    }
}
