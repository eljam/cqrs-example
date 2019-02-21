<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\EventListener;

use App\Domain\Event\TripWasCreatedEvent;
use Psr\Log\LoggerInterface;

class LogAfterTripWasCreatedListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogAfterUserIsCreatedListener constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(TripWasCreatedEvent $tripWasCreatedEvent)
    {
        $this->logger->info(\sprintf('Trip %s has been created', $tripWasCreatedEvent->tripName()));
    }
}
