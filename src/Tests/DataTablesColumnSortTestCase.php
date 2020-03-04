<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Model\DataTablesColumnSort;
use PHPUnit\Framework\TestCase;

class DataTablesColumnSortTestCase extends TestCase
{
    public function testColumnWithArray()
    {
        $detail = DataTablesColumnSort::create('testProperty', 'asc');

        $this->assertSame('testProperty', $detail->getField());
        $this->assertSame('asc', $detail->getOrder());
    }
}