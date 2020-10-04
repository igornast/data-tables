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

    public function __construct(string $name, string $entity)
    {
        $this->listing = Listing::create($name, $entity);
    }

    public function mainSearchField(string $field): ListingBuilderInterface
    {
        $this->listing->addMainSearchField($field);

        return $this;
    }

    public function column(string $field, string $label): ListingBuilderInterface
    {
        $this->listing->addColumn($field, $label);

        return $this;
    }

    public function template(string $template): ListingBuilderInterface
    {
        $this->listing->setTemplate($template);

        return $this;
    }

    public function getListing(): ListingInterface
    {
        return $this->listing;
    }
}