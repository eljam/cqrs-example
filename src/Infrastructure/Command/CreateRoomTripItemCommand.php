<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Command;

use App\Application\Command\CreateRoomTripItem\CreateRoomTripItemCommand as CreateRoomTripItem;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateTripCommand.
 */
class CreateRoomTripItemCommand extends Command
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:create-room-trip-item')
            ->setDescription('Given a cost paxlist passport tripId and an id, generates a new flightItem.')
            ->addArgument('cost', InputArgument::REQUIRED, 'Room cost')
            ->addArgument('paxList', InputArgument::REQUIRED, 'Room Pax List')
            ->addArgument('adults', InputArgument::REQUIRED, 'Number of adutls')
            ->addArgument('children', InputArgument::REQUIRED, 'Number of children')
            ->addArgument('tripId', InputArgument::REQUIRED, 'Trip id')
            ->addArgument('accommodationId', InputArgument::REQUIRED, 'Flight Trip Item id')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CreateRoomTripItem $command */
        $command                    = new CreateRoomTripItem();
        $command->id                = Uuid::uuid4();
        $command->tripId            = Uuid::fromString($input->getArgument('tripId'));
        $command->accommodationId   = Uuid::fromString($input->getArgument('accommodationId'));
        $command->adults            = (int) $input->getArgument('adults');
        $command->children          = (int) $input->getArgument('children');
        $command->cost              = (int) $input->getArgument('cost');
        $command->paxList           = $input->getArgument('paxList');

        $this->commandBus->handle($command);

        $output->writeln('<info>Room Trip Item Created: </info>');
        $output->writeln('');
        $output->writeln(\sprintf('Id: %s', $command->id->toString()));
        $output->writeln("PaxList: $command->paxList");
    }
}
