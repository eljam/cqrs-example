<?php

declare(strict_types=1);

/*
 * Have fun !
 */

namespace App\Infrastructure\Doctrine\DoctrineExtensions\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

class UTCDateTimeType extends DateTimeType
{
    /**
     * $utc.
     *
     * @var \DateTimeZone|null
     */
    private static $utc = null;

    /**
     * ConvertToDatabaseValue.
     *
     * @param \DateTime        $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null == $value) {
            return null;
        }

        $value->setTimezone((self::$utc) ? self::$utc : (self::$utc = new \DateTimeZone('UTC')));

        return $value->format($platform->getDateTimeFormatString());
    }

    /**
     * ConvertToPHPValue.
     *
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return \DateTime
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTime
    {
        if (null == $value) {
            return null;
        }

        $val = \DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            $value,
            (self::$utc) ? self::$utc : (self::$utc = new \DateTimeZone('UTC'))
        );
        if (!$val) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $val;
    }
}
