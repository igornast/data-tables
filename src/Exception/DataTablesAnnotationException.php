<?php declare(strict_types=1);


namespace Igornast\DataTables\Exception;


use Exception;

class DataTablesAnnotationException extends Exception
{
    public static function annotationNotFoundException(string $controller): self
    {
        return new static(sprintf('DataTables annotation not found for "%s" controller.', $controller));
    }

    public static function badConfigurationException(string $controller): self
    {
        return new static(sprintf('DataTables annotation required fields "class" and "searchField" for "%s" controller.', $controller));
    }

    public static function routeNotFoundException(string $pathName): self
    {
        return new static(sprintf('Route "%s", not found.', $pathName));
    }
}