<?php declare(strict_types=1);


namespace Igornast\DataTables\Annotation;

use Igornast\DataTables\ListingBuilder\ListingBuilder;

/**
 * Class DataTables
 * @Annotation
 * @deprecated Add class name by ListingBuilder
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

    public function __construct()
    {
        trigger_error(sprintf('Annotation class "%s" is deprecated  and will be removed in 2.0, pass name by "%s"', __CLASS__, ListingBuilder::class), E_USER_DEPRECATED);
    }
}