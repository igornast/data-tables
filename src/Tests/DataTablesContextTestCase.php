<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Model\Context\DataTablesContext;
use Igornast\DataTables\Model\DataTablesColumn;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DataTablesContextTestCase extends TestCase
{
    public function testEmptyRequestForContext()
    {
        /** @var MockObject|RequestStack $stack */
        $stack = $this->getRequestStackMock(new Request());
        $context = new DataTablesContext($stack);

        $this->assertSame(0, $context->getDraw());
        $this->assertSame(0, $context->getOffset());
        $this->assertSame(0, $context->getLimit());

        $this->assertSame(null, $context->getPathName());
        $this->assertSame(null, $context->getSearch());

        $this->assertCount(0, $context->getColumns());
        $this->assertCount(0, $context->getSortArray());
    }

    private function getRequestStackMock(Request $request): MockObject
    {
        $mock = $this->createMock(RequestStack::class);

        $mock
            ->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        return $mock;
    }

    public function testWithoutColumns()
    {
        $request = new Request();
        $request->request->add([
            'draw' => 2,
            'start' => 10,
            'length' => 25,
            'path_name' => 'test_path_name'
        ]);

        /** @var MockObject|RequestStack $stack */
        $stack = $this->getRequestStackMock($request);
        $context = new DataTablesContext($stack);

        $this->assertSame(2, $context->getDraw());
        $this->assertSame(10, $context->getOffset());
        $this->assertSame(25, $context->getLimit());

        $this->assertSame('test_path_name', $context->getPathName());
        $this->assertSame(null, $context->getSearch());

        $this->assertCount(0, $context->getColumns());
        $this->assertCount(0, $context->getSortArray());
    }

    public function testWithColumns()
    {
        $request = new Request();
        $request->request->add([
            'draw' => 2,
            'start' => 10,
            'length' => 25,
            'path_name' => 'test_path_name',
            'columns' => [
                ['data' => 'id', 'name' => 'Id', 'search' => ['value' => 'search_value']],
                ['data' => 'type', 'name' => 'Type', 'search' => ['value' => 'search_value']]
            ]
        ]);

        /** @var MockObject|RequestStack $stack */
        $stack = $this->getRequestStackMock($request);
        $context = new DataTablesContext($stack);

        $this->assertSame(2, $context->getDraw());
        $this->assertSame(10, $context->getOffset());
        $this->assertSame(25, $context->getLimit());

        $this->assertSame('test_path_name', $context->getPathName());
        $this->assertSame(null, $context->getSearch());

        $this->assertCount(2, $context->getColumns());
        $this->assertCount(0, $context->getSortArray());
    }

    public function testContextColumnInit()
    {
        $request = new Request();
        $request->request->add([
            'columns' => [
                ['data' => 'idProperty', 'name' => 'Id Column', 'search' => ['value' => 'search_value']],
                ['data' => 'type', 'name' => 'Type', 'search' => ['value' => 'search_value']]
            ]
        ]);

        /** @var MockObject|RequestStack $stack */
        $stack = $this->getRequestStackMock($request);
        $context = new DataTablesContext($stack);
        $columns = $context->getColumns();
        $column = $columns[0];

        $this->assertCount(2, $columns);
        $this->assertInstanceOf(DataTablesColumn::class, $column);

        $this->assertSame(0, $column->getId());
        $this->assertSame('Id Column', $column->getName());
        $this->assertSame('idProperty', $column->getPropertyName());
        $this->assertSame('search_value', $column->getSearch());
        $this->assertNull($column->getOrder());
    }

    public function testContextColumnAndOrderInit()
    {
        $request = new Request();
        $request->request->add([
            'columns' => [
                ['data' => 'idProperty', 'name' => 'Id Column', 'search' => ['value' => 'search_value']],
                ['data' => 'typeProperty', 'name' => 'Type Column', 'search' => ['value' => 'type_search_value']]
            ],
            'order' => [
                ['column' => 1, 'dir' => 'asc']
            ]
        ]);

        /** @var MockObject|RequestStack $stack */
        $stack = $this->getRequestStackMock($request);
        $context = new DataTablesContext($stack);
        $columns = $context->getColumns();
        $columnOne = $columns[0];
        $columnTwo = $columns[1];

        $this->assertCount(2, $columns);
        $this->assertInstanceOf(DataTablesColumn::class, $columnTwo);

        $this->assertSame(null, $columnOne->getOrder());

        $this->assertSame(1, $columnTwo->getId());
        $this->assertSame('Type Column', $columnTwo->getName());
        $this->assertSame('typeProperty', $columnTwo->getPropertyName());
        $this->assertSame('type_search_value', $columnTwo->getSearch());
        $this->assertSame('asc', $columnTwo->getOrder());
    }
}