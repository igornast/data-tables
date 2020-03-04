<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Listing\Listing;
use PHPUnit\Framework\TestCase;

class ListingTestCase extends TestCase
{
    public function testAddListingName()
    {
        $listing = Listing::create('awesome_listing_name', 'test_path', []);

        $this->assertSame('awesome_listing_name', $listing->getName());
    }

    public function testAddPathName()
    {
        $listing = Listing::create('awesome_listing_name', 'test_path', []);

        $this->assertSame('test_path', $listing->getPathName());
    }

    public function testAddOneColumn()
    {
        $listing = Listing::create('TestName', 'test_path', []);
        $listing->addColumn('testProperty', 'Property_Name');

        $this->assertCount(1, $listing->getColumns());
    }

    public function testAddMoreColumns()
    {
        $listing = Listing::create('TestName', 'test_path', []);
        $listing->addColumn('testPropertyOne', 'Property_Name');
        $listing->addColumn('testPropertyTwo', 'Property_Name');
        $listing->addColumn('testPropertyThree', 'Property_Name');
        $listing->addColumn('testPropertyFour', 'Property_Name');

        $this->assertCount(4, $listing->getColumns());
    }
}