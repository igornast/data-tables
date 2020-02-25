<?php declare(strict_types=1);


namespace Igornast\DataTables\ListingBuilder;


use Igornast\DataTables\Listing\Listing;

interface ListingBuilderInterface
{
    public function addColumn(string $field, string $label): Listing;
}