<?php declare(strict_types=1);


namespace Igornast\DataTables\Controller;


use Igornast\DataTables\ListingBuilder\ListingBuilder;
use Igornast\DataTables\Service\ListingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @deprecated Use ListingManager service
 * Class AbstractDataTablesController
 * @package Igornast\DataTables\Controller
 */
abstract class AbstractDataTablesController extends AbstractController
{
    /**
     * @deprecated
     * @param string $name
     * @param string $pathName
     * @return ListingBuilder
     */
    protected function createListingBuilder(string $name, string $pathName): ListingBuilder
    {
        trigger_error(sprintf('Method "%s" is deprecated, use "%s::createListingBuilder"', __METHOD__, ListingManager::class), E_USER_DEPRECATED);

        return new ListingBuilder($name, $pathName);
    }
}