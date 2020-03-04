<?php declare(strict_types=1);


namespace Igornast\DataTables\ListingBuilder;


use Igornast\DataTables\Listing\Listing;
use Igornast\DataTables\Listing\ListingInterface;

class ListingBuilder implements ListingBuilderInterface
{
    /**
     * @var Listing
     */
    private $listing;

    public function __construct(string $name, string $pathName)
    {
        $this->listing = Listing::create($name, $pathName, []);
    }

    public function addColumn(string $field, string $label): ListingBuilderInterface
    {
        $this->listing->addColumn($field, $label);

        return $this;
    }

    public function getListing(): ListingInterface
    {
        return $this->listing;
    }
}