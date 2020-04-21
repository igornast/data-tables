<?php declare(strict_types=1);


namespace Igornast\DataTables\Model;


class DataTablesColumnSort
{
    /**
     * @var string
     */
    private string $field;
    /**
     * @var string
     */
    private string $order;

    public static function create(string $field, string $order): self
    {
        $obj = new self();
        $obj->field = $field;
        $obj->order = $order;

        return $obj;
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
    public function getOrder(): string
    {
        return $this->order;
    }
}