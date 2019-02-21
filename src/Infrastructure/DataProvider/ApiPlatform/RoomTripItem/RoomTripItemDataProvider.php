<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\DataProvider\ApiPlatform\RoomTripItem;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Application\Query\GetRoomTripItem\GetRoomTripItemQuery;
use App\Application\Query\GetRoomTripItems\GetRoomTripItemsQuery;
use App\Application\Query\Projection\RoomTripItemView;
use App\Domain\Exception\Query\RoomTripItemNotFoundException;
use App\Infrastructure\DataProvider\ApiPlatform\AbstractDataProvider;
use App\Infrastructure\DataProvider\ApiPlatform\DataProviderInterface;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

/**
 * Class TripDataProvider.
 */
final class RoomTripItemDataProvider extends AbstractDataProvider implements
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
     * @return RoomTripItemView
     *
     * @throws RoomTripItemNotFoundException
     */
    public function getItem(
        string $resourceClass,
        $id,
        string $operationName = null,
        array $context = []
    ): RoomTripItemView {
        $query     = new GetRoomTripItemQuery();
        $query->id = $id;

        $trip = $this->getQueryBus()->handle($query);

        try {
            Assert::minCount($trip, 1);
        } catch (\InvalidArgumentException $e) {
            throw RoomTripItemNotFoundException::withId($query->id->toString());
        }

        return RoomTripItemView::fromArray($trip[0]);
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

        $query        = new GetRoomTripItemsQuery();
        $query->page  = $page;
        $query->limit = $limit;

        $roomTripItems = $this->getQueryBus()->handle($query);

        foreach ($roomTripItems as $roomTripItem) {
            yield RoomTripItemView::fromArray($roomTripItem);
        }
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return RoomTripItemView::class === $resourceClass;
    }
}
