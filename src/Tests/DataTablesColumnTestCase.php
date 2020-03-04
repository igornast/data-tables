<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Model\DataTablesColumn;
use PHPUnit\Framework\TestCase;

class DataTablesColumnTestCase extends TestCase
{
    public function testColumnWithArray()
    {
        $detail = DataTablesColumn::create(0, 'testProperty', 'Test Name', '', 'asc');

        $this->assertSame(0, $detail->getId());
        $this->assertSame('testProperty', $detail->getPropertyName());
        $this->assertSame('Test Name', $detail->getName());
        $this->assertSame('', $detail->getSearch());
        $this->assertSame('asc', $detail->getOrder());
    }
}