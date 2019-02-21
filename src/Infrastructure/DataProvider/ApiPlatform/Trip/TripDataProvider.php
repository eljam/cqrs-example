<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\DataProvider\ApiPlatform\Trip;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\Query\GetTrip\GetTripQuery;
use App\Application\Query\GetTrips\GetTripsQuery;
use App\Application\Query\Projection\TripView;
use App\Domain\Exception\Query\TripNotFoundException;
use App\Infrastructure\DataProvider\ApiPlatform\AbstractDataProvider;
use App\Infrastructure\DataProvider\ApiPlatform\DataProviderInterface;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

/**
 * Class TripDataProvider.
 */
final class TripDataProvider extends AbstractDataProvider implements
    ItemDataProviderInterface,
    CollectionDataProviderInterface,
    RestrictedDataProviderInterface,
    DataProviderInterface
{
    /**
     * Retrieves an item.
     *
     * @param string                         $resourceClass
     * @param array|int|string|UuidInterface $id
     * @param string|null                    $operationName
     * @param array                          $context
     *
     * @return TripView
     *
     * @throws TripNotFoundException
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): TripView
    {
        $query     = new GetTripQuery();
        $query->id = $id;

        $trip = $this->getQueryBus()->handle($query);

        try {
            Assert::minCount($trip, 1);
        } catch (\InvalidArgumentException $e) {
            throw TripNotFoundException::withId($query->id->toString());
        }

        return TripView::fromArray($trip[0]);
    }

    /**
     * Retrieves a collection.
     *
     * @param string      $resourceClass
     * @param string|null $operationName
     *
     * @return \Generator
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        [$page, $offset, $limit] = $this->getPagination($resourceClass, $operationName, []);

        $query        = new GetTripsQuery();
        $query->page  = $page;
        $query->limit = $limit;

        $trips = $this->getQueryBus()->handle($query);

        foreach ($trips as $trip) {
            yield TripView::fromArray($trip);
        }
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return TripView::class === $resourceClass;
    }
}
