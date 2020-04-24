<?php


namespace Igornast\DataTables\Service;


use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Igornast\DataTables\ListingBuilder\ListingBuilder;
use Igornast\DataTables\ListingBuilder\ListingBuilderInterface;

class ListingManager
{
    /**
     * @var DataTablesCryptoManager
     */
    private $cryptoManager;

    public function __construct(DataTablesCryptoManager $cryptoManager)
    {
        $this->cryptoManager = $cryptoManager;
    }

    /**
     * @param string $name
     * @param string $entity
     * @return ListingBuilderInterface
     * @throws EnvironmentIsBrokenException
     */
    public function createListingBuilder(string $name, string $entity): ListingBuilderInterface
    {
        return new ListingBuilder($name, null, $this->cryptoManager->encrypt($entity));
    }
}