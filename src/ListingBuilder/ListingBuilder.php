<?php declare(strict_types=1);


namespace Igornast\DataTables\ListingBuilder;


use Igornast\DataTables\Listing\Listing;
use Igornast\DataTables\Listing\ListingInterface;

class ListingBuilder implements ListingBuilderInterface
{
    /**
     * @var Listing
     */
    private Listing $listing;

    public function __construct(string $name, ?string $pathName = null, ?string $entity = null)
    {
        $this->listing = Listing::create($name, $pathName, $entity);
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

    /**
     * @deprecated
     * @param string $field
     * @param string $label
     * @return ListingBuilderInterface
     */
    public function addColumn(string $field, string $label): ListingBuilderInterface
    {
        trigger_error(sprintf('Method "%s" is deprecated, use "%s::column"', __METHOD__, ListingBuilder::class), E_USER_DEPRECATED);

        return $this->column($field, $label);
    }

    public function getListing(): ListingInterface
    {
        return $this->listing;
    }
}