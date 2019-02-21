<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Application\Command\CreateTrip;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Model\Trip;
use App\Domain\Repository\TripRepositoryInterface;

final class CreateTripHandler implements CommandHandlerInterface
{
    /**
     * @var TripRepositoryInterface
     */
    private $tripRepository;

    /**
     * CreateTripHandler constructor.
     *
     * @param TripRepositoryInterface $tripRepository
     */
    public function __construct(TripRepositoryInterface $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
     * @param CreateTripCommand $command
     */
    public function __invoke(CreateTripCommand $command)
    {
        $this->tripRepository->save(
            Trip::create($command->id, $command->name, $command->description)
        );
    }
}
