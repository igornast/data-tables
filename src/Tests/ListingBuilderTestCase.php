<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\ListingBuilder\ListingBuilder;
use PHPUnit\Framework\TestCase;

class ListingBuilderTestCase extends TestCase
{
    public function testAddListingName()
    {
        $listingBuilder = new ListingBuilder('awesome_listing_name', 'encrypted_entity_name');

        $this->assertSame('awesome_listing_name', $listingBuilder->getListing()->getName());
    }

    public function testInitializeWithEntityName()
    {
        $listingBuilder = new ListingBuilder('awesome_listing_name', 'encrypted_entity_name');

        $this->assertSame('encrypted_entity_name', $listingBuilder->getListing()->getEncryptedEntity());
    }

    public function testAddOneColumn()
    {
        $listingBuilder = (new ListingBuilder('awesome_listing_name', 'encrypted_entity_name'))
            ->column('testProperty', 'Property_Name');

        $this->assertCount(1, $listingBuilder->getListing()->getColumns());
    }

    public function testAddMoreColumns()
    {
        $listingBuilder = (new ListingBuilder('awesome_listing_name', 'encrypted_entity_name'))
            ->column('testPropertyOne', 'Property_Name')
            ->column('testPropertyTwo', 'Property_Name')
            ->column('testPropertyThree', 'Property_Name')
            ->column('testPropertyFour', 'Property_Name');

        $this->assertCount(4, $listingBuilder->getListing()->getColumns());
    }

    public function testAddCustomTemplate()
    {
        $template = 'listing/custom_listing.html.twig';

        $listingBuilder = (new ListingBuilder('awesome_listing_name', 'encrypted_entity_name'))
            ->template($template);

        $this->assertEquals($template, $listingBuilder->getListing()->getTemplate());
    }
}