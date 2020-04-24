<?php declare(strict_types=1);


namespace Igornast\DataTables\Model;


class ControllerDetail
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var string
     */
    private $methodName;

    public static function createFromArray(array $data): self
    {
        $obj = new self();
        $obj->className = $data[0];
        $obj->methodName = $data[1];

        return $obj;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }
}