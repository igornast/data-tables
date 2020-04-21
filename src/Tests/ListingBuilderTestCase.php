<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\ListingBuilder\ListingBuilder;
use PHPUnit\Framework\TestCase;

class ListingBuilderTestCase extends TestCase
{
    public function testAddListingName()
    {
        $listingBuilder = new ListingBuilder('awesome_listing_name', 'test_path');

        $this->assertSame('awesome_listing_name', $listingBuilder->getListing()->getName());
    }

    public function testAddPathName()
    {
        $listingBuilder = new ListingBuilder('awesome_listing_name', 'test_path');

        $this->assertSame('test_path', $listingBuilder->getListing()->getPathName());
    }

    public function testAddOneColumn()
    {
        $listingBuilder = (new ListingBuilder('awesome_listing_name', 'test_path'))
            ->column('testProperty', 'Property_Name');

        $this->assertCount(1, $listingBuilder->getListing()->getColumns());
    }

    public function testAddMoreColumns()
    {
        $listingBuilder = (new ListingBuilder('awesome_listing_name', 'test_path'))
            ->column('testPropertyOne', 'Property_Name')
            ->column('testPropertyTwo', 'Property_Name')
            ->column('testPropertyThree', 'Property_Name')
            ->column('testPropertyFour', 'Property_Name');

        $this->assertCount(4, $listingBuilder->getListing()->getColumns());
    }
}