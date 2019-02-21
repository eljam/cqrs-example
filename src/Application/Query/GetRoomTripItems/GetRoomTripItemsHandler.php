<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Query\GetRoomTripItems;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Repository\RoomTripItemRepositoryInterface;

/**
 * Class GetTripsHandler.
 */
final class GetRoomTripItemsHandler implements QueryHandlerInterface
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
     * @param GetRoomTripItemsQuery $query
     *
     * @return array
     */
    public function __invoke(GetRoomTripItemsQuery $query): array
    {
        return $this->roomTripItemRepository->findAll($query->page, $query->limit);
    }
}
