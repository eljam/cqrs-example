<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Query\GetTrip;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Repository\TripRepositoryInterface;

/**
 * Class GetTripsHandler.
 */
final class GetTripHandler implements QueryHandlerInterface
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
     * @param GetTripQuery $query
     *
     * @return array
     */
    public function __invoke(GetTripQuery $query): array
    {
        return $this->tripRepository->find($query->id);
    }
}
