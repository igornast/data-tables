<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Listing\Listing;
use PHPUnit\Framework\TestCase;

class ListingTestCase extends TestCase
{
    public function testAddListingName()
    {
        $listing = Listing::create('awesome_listing_name', 'encrypted_entity_name');

        $this->assertSame('awesome_listing_name', $listing->getName());
    }

    public function testAddOneColumn()
    {
        $listing = Listing::create('TestName', 'encrypted_entity_name');
        $listing->addColumn('testProperty', 'Property_Name');

        $this->assertCount(1, $listing->getColumns());
    }
    public function testAddMoreColumns()
    {
        $listing = Listing::create('TestName', 'encrypted_entity_name');
        $listing->addColumn('testPropertyOne', 'Property_Name');
        $listing->addColumn('testPropertyTwo', 'Property_Name');
        $listing->addColumn('testPropertyThree', 'Property_Name');
        $listing->addColumn('testPropertyFour', 'Property_Name');

        $this->assertCount(4, $listing->getColumns());
    }

    public function testAddCustomTemplate()
    {
        $template = 'listing/custom_listing.html.twig';

        $listing = Listing::create('TestName', 'encrypted_entity_name');
        $listing->setTemplate($template);

        $this->assertEquals($template, $listing->getTemplate());
    }
}