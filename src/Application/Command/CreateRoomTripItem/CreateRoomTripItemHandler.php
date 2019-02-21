<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Command\CreateRoomTripItem;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Exception\Command\AccommodationNotFoundException;
use App\Domain\Exception\Command\TripNotFoundException;
use App\Domain\Model\RoomTripItem;
use App\Domain\Repository\AccommodationRepositoryInterface;
use App\Domain\Repository\RoomTripItemRepositoryInterface;
use App\Domain\Repository\TripRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class CreateRoomTripItemHandler.
 */
final class CreateRoomTripItemHandler implements CommandHandlerInterface
{
    /**
     * @var RoomTripItemRepositoryInterface
     */
    private $roomTripItemRepository;

    /**
     * @var AccommodationRepositoryInterface
     */
    private $accommodationRepository;

    /**
     * @var TripRepositoryInterface
     */
    private $tripRepository;

    /**
     * CreateTripHandler constructor.
     *
     * @param RoomTripItemRepositoryInterface  $roomTripItemRepository
     * @param AccommodationRepositoryInterface $accommodationRepository
     * @param TripRepositoryInterface          $tripRepository
     */
    public function __construct(
        RoomTripItemRepositoryInterface $roomTripItemRepository,
        AccommodationRepositoryInterface $accommodationRepository,
        TripRepositoryInterface $tripRepository
    ) {
        $this->roomTripItemRepository  = $roomTripItemRepository;
        $this->accommodationRepository = $accommodationRepository;
        $this->tripRepository          = $tripRepository;
    }

    /**
     * @param CreateRoomTripItemCommand $command
     *
     * @throws AccommodationNotFoundException
     * @throws TripNotFoundException
     */
    public function __invoke(CreateRoomTripItemCommand $command)
    {
        try {
            $accommodation = $this->accommodationRepository->findAndReturnObject($command->accommodationId);
        } catch (NonUniqueResultException $e) {
            throw AccommodationNotFoundException::withId($command->accommodationId->toString());
        }

        try {
            $trip = $this->tripRepository->findAndReturnObject($command->tripId);
        } catch (NonUniqueResultException $e) {
            throw TripNotFoundException::withId($command->tripId->toString());
        }

        $roomTripItem = RoomTripItem::create(
            $command->id,
            $command->adults,
            $command->children,
            $command->paxList,
            $command->cost,
            $accommodation,
            $trip
        );

        $this->roomTripItemRepository->save($roomTripItem);
    }
}
