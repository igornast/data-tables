<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Model\ControllerDetail;
use PHPUnit\Framework\TestCase;

class ControllerDetailTestCase extends TestCase
{
    public function testDetailWithArray()
    {
        $detail = ControllerDetail::createFromArray(['App\Controller\Class', 'controllerAction']);

        $this->assertSame('controllerAction', $detail->getMethodName());
        $this->assertSame('App\Controller\Class', $detail->getClassName());
    }
}