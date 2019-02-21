<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\DataProvider\ApiPlatform;

use ApiPlatform\Core\DataProvider\Pagination;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use League\Tactician\CommandBus;

abstract class AbstractDataProvider
{
    /**
     * @var ResourceMetadataFactoryInterface
     */
    private $resourceMetadataFactory;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var CommandBus
     */
    private $queryBus;

    /**
     * AbstractDataProvider constructor.
     *
     * @param ResourceMetadataFactoryInterface $resourceMetadataFactory
     * @param Pagination                       $apiPagination
     * @param CommandBus                       $queryBus
     */
    public function __construct(
        ResourceMetadataFactoryInterface $resourceMetadataFactory,
        Pagination $apiPagination,
        CommandBus $queryBus
    ) {
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->pagination              = $apiPagination;
        $this->queryBus                = $queryBus;
    }

    public function getPagination(string $resourceClass, string $operationName, array $context = null): array
    {
        return $this->pagination->getPagination($resourceClass, $operationName, $context);
    }

    public function getQueryBus()
    {
        return $this->queryBus;
    }
}
