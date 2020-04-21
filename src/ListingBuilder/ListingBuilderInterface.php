<?php declare(strict_types=1);


namespace Igornast\DataTables\ListingBuilder;


use Igornast\DataTables\Listing\ListingInterface;

interface ListingBuilderInterface
{
    /**
     * @deprecated
     */
    public function addColumn(string $field, string $label): ListingBuilderInterface;

    public function column(string $field, string $label): ListingBuilderInterface;

    public function mainSearchField(string $field): ListingBuilderInterface;

    public function getListing(): ListingInterface;
}