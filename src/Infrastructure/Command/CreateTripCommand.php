<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Command;

use App\Application\Command\CreateTrip\CreateTripCommand as CreateTrip;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateTripCommand.
 */
class CreateTripCommand extends Command
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
            ->setName('app:create-trip')
            ->setDescription('Given a name and description, generates a new trip.')
            ->addArgument('name', InputArgument::REQUIRED, 'Flight Trip Item cost')
            ->addArgument('description', InputArgument::REQUIRED, 'Flight Pax List cost')
            ->addArgument('id', InputArgument::OPTIONAL, 'Flight Trip id')
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
        /** @var CreateTrip $command */
        $command               = new CreateTrip();
        $command->id           = ($input->getArgument('id') ? Uuid::fromString($input->getArgument('id')) : Uuid::uuid4()); //php_cs:ignore
        $command->name         = $input->getArgument('name');
        $command->description  = $input->getArgument('description');

        $this->commandBus->handle($command);

        $output->writeln('<info>Flight Trip Item Created: </info>');
        $output->writeln('');
        $output->writeln(\sprintf('Id: %s', $command->id->toString()));
        $output->writeln("Name: $command->name");
    }
}
