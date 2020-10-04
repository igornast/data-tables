<?php declare(strict_types=1);


namespace Igornast\DataTables\ListingBuilder;


use Igornast\DataTables\Listing\ListingInterface;

interface ListingBuilderInterface
{
    public function column(string $field, string $label): ListingBuilderInterface;

    public function mainSearchField(string $field): ListingBuilderInterface;

    public function template(string $template): ListingBuilderInterface;

    public function getListing(): ListingInterface;
}