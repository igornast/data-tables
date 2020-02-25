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
    private $field;
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
    private $sort;

    public static function create(int $id, string $field, string $name, string $search, ?string $sort): self
    {
        $obj = new self();
        $obj->id = $id;
        $obj->field = $field;
        $obj->name = $name;
        $obj->search = $search;
        $obj->sort = $sort;

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
    public function getField(): string
    {
        return $this->field;
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
    public function getSort(): ?string
    {
        return $this->sort;
    }
}