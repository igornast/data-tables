<?php declare(strict_types=1);


namespace Igornast\DataTables\Exception;


use InvalidArgumentException;

class ListingInvalidArgumentException extends InvalidArgumentException
{
    public static function NullArgumentsGiven(): self
    {
        return new static('Either "pathName" or "encryptedEntity" should not be null.');
    }

    public static function NotNullArgumentsGiven(): self
    {
        return new static('Either "pathName" or "encryptedEntity" should be null.');
    }
}