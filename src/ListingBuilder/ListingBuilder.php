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

    public function __construct(string $name, ?string $pathName = null, ?string $entity = null)
    {
        $this->listing = Listing::create($name, $pathName, $entity);
    }

    public function mainSearchField(string $field): ListingBuilderInterface
    {
        $this->listing->addMainSearchField($field);

        return $this;
    }

    /**
     * @param string $field
     * @param string $label
     * @return ListingBuilderInterface
     * @deprecated
     */
    public function addColumn(string $field, string $label): ListingBuilderInterface
    {
        trigger_error(sprintf('Method "%s" is deprecated and will be removed in 2.0, use "%s::column"', __METHOD__, ListingBuilder::class), E_USER_DEPRECATED);

        return $this->column($field, $label);
    }

    public function column(string $field, string $label): ListingBuilderInterface
    {
        $this->listing->addColumn($field, $label);

        return $this;
    }

    public function getListing(): ListingInterface
    {
        return $this->listing;
    }
}