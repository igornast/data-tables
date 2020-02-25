<?php declare(strict_types=1);


namespace Igornast\DataTables\Controller;


use Igornast\DataTables\ListingBuilder\ListingBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractDataTablesController extends AbstractController
{
    protected function createListingBuilder(string $name, string $pathName): ListingBuilder
    {
        return new ListingBuilder($name, $pathName);
    }
}