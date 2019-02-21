<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\DataProvider\ApiPlatform\Trip;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Application\Command\CreateTrip\CreateTripCommand;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;

/**
 * Class TripDataPersister.
 */
final class TripDataPersister implements DataPersisterInterface
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * CreateTripHandler constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param CreateTripCommand $data
     *
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof CreateTripCommand;
    }

    /**
     * @param object $data
     *
     * @throws \Exception
     */
    public function persist($data): void
    {
        $data->id = Uuid::uuid4();
        $this->commandBus->handle($data);
    }

    /**
     * Removes the data.
     *
     * @param object $data
     */
    public function remove($data): void
    {
        $this->commandBus->handle($data);
    }
}
