<?php declare(strict_types=1);


namespace Igornast\DataTables\Model;


class DataTablesColumn
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $propertyName;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $search;
    /**
     * @var null|string
     */
    private $order;

    public static function create(int $id, string $field, string $name, string $search, ?string $order): self
    {
        $obj = new self();
        $obj->id = $id;
        $obj->propertyName = $field;
        $obj->name = $name;
        $obj->search = $search;
        $obj->order = $order;

        return $obj;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @return null|string
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }
}