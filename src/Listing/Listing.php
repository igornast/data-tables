<?php declare(strict_types=1);


namespace Igornast\DataTables\Listing;


use Igornast\DataTables\Exception\ListingInvalidArgumentException;

class Listing implements ListingInterface
{
    const DEFAULT_TEMPLATE = '@IgornastDataTables/listing/default_listing.html.twig';
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $columns;
    /**
     * @var array
     */
    private $filters;
    /**
     * @var array
     */
    private $options;
    /**
     * @var null|string
     */
    private $pathName;
    /**
     * @var string
     */
    private $template;
    /**
     * @var null|string
     */
    private $encryptedEntity;
    /**
     * @var null|string
     */
    private $mainSearchField;

    public static function create(string $name, ?string $pathName = null, ?string $encryptedEntity = null): self
    {
        if(is_null($pathName) && is_null($encryptedEntity)) {
            throw ListingInvalidArgumentException::NullArgumentsGiven();
        }

        if(is_null($pathName) === false && is_null($encryptedEntity) === false) {
            throw ListingInvalidArgumentException::NotNullArgumentsGiven();
        }

        $obj = new self();
        $obj->name = $name;
        $obj->columns = [];
        $obj->encryptedEntity = $encryptedEntity;
        $obj->filters = [];
        $obj->options = [];
        $obj->pathName = $pathName;
        $obj->mainSearchField = null;
        $obj->template = self::DEFAULT_TEMPLATE;

        return $obj;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return null|string
     */
    public function getPathName(): ?string
    {
        return $this->pathName;
    }

    /**
     * @return string|null
     */
    public function getMainSearchField(): ?string
    {
        return $this->mainSearchField;
    }

    /**
     * @return string|null
     */
    public function getEncryptedEntity(): ?string
    {
        return $this->encryptedEntity;
    }

    public function addColumn(string $field, string $label): self
    {
        $this->columns = array_merge($this->columns, [$field => ['label' => $label]]);

        return $this;
    }

    public function addMainSearchField(string $field): self
    {
        $this->mainSearchField = $field;

        return $this;
    }
}