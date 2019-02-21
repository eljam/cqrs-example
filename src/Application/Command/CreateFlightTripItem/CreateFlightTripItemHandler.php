<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Command\CreateFlightTripItem;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Model\FlightTripItem;
use App\Domain\Repository\FlightTripItemRepositoryInterface;

final class CreateFlightTripItemHandler implements CommandHandlerInterface
{
    /**
     * @var FlightTripItemRepositoryInterface
     */
    private $flightTripItemRepository;

    /**
     * CreateTripHandler constructor.
     *
     * @param FlightTripItemRepositoryInterface $flightTripItemRepository
     */
    public function __construct(FlightTripItemRepositoryInterface $flightTripItemRepository)
    {
        $this->flightTripItemRepository = $flightTripItemRepository;
    }

    /**
     * @param CreateFlightTripItemCommand $command
     */
    public function __invoke(CreateFlightTripItemCommand $command)
    {
        $this->flightTripItemRepository->save(
            FlightTripItem::create(
                $command->id,
                $command->tripId,
                $command->passport,
                $command->cost,
                $command->paxList
            )
        );
    }
}
