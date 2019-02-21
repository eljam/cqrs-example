<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Domain\Shared\Command;

use App\Domain\Shared\DomainExceptionInterface;

/**
 * Class NotFoundException.
 */
class NotFoundException extends \Exception implements DomainExceptionInterface
{
}
