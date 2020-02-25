<?php declare(strict_types=1);


namespace Igornast\DataTables\Annotation;

/**
 * Class DataTables
 * @Annotation
 * @package Igornast\DataTables\Annotation
 */
class DataTables
{
    /**
     * @var string
     */
    public $entity;

    /**
     * @var string
     */
    public $searchField;
}