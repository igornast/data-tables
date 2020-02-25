<?php declare(strict_types=1);


namespace Igornast\DataTables\Listing;


class Listing
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
     * @var string
     */
    private $pathName;
    /**
     * @var string
     */
    private $template;

    public static function create(string $name, string $pathName, array $columns): self
    {
        $obj = new self();
        $obj->name = $name;
        $obj->columns = $columns;
        $obj->filters = [];
        $obj->options = [];
        $obj->pathName = $pathName;
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
     * @return string
     * @
     */
    public function getPathName(): string
    {
        return $this->pathName;
    }

    public function addColumn(string $field, string $label): self
    {
        $this->columns = array_merge($this->columns, [$field => ['label' => $label]]);

        return $this;
    }
}