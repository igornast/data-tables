<?php declare(strict_types=1);


namespace Igornast\DataTables\ListingBuilder;


use Igornast\DataTables\Listing\Listing;
use Igornast\DataTables\Listing\ListingInterface;

interface ListingBuilderInterface
{
    public function addColumn(string $field, string $label): ListingBuilderInterface;

    public function getListing(): ListingInterface;
}