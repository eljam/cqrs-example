<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Query\GetRoomTripItem;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Repository\RoomTripItemRepositoryInterface;

/**
 * Class GetTripsHandler.
 */
final class GetRoomTripItemHandler implements QueryHandlerInterface
{
    /**
     * @var RoomTripItemRepositoryInterface
     */
    private $roomTripItemRepository;

    /**
     * GetTripsHandler constructor.
     *
     * @param RoomTripItemRepositoryInterface $roomTripItemRepository
     */
    public function __construct(RoomTripItemRepositoryInterface $roomTripItemRepository)
    {
        $this->roomTripItemRepository = $roomTripItemRepository;
    }

    /**
     * @param GetRoomTripItemQuery $query
     *
     * @return array
     */
    public function __invoke(GetRoomTripItemQuery $query): array
    {
        return $this->roomTripItemRepository->find($query->id);
    }
}
