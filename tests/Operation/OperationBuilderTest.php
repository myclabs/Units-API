<?php

namespace UnitTest\MyCLabs\UnitAPI\Operation;

use MyCLabs\UnitAPI\Operation\OperationBuilder;
use MyCLabs\UnitAPI\Operation\OperationComponent;

/**
 * @covers \MyCLabs\UnitAPI\Operation\OperationBuilder
 */
class OperationBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testAddition()
    {
        $operation = OperationBuilder::addition()->getOperation();
        $this->assertInstanceOf('MyCLabs\UnitAPI\Operation\Addition', $operation);
    }

    public function testMultiplication()
    {
        $operation = OperationBuilder::multiplication()->getOperation();
        $this->assertInstanceOf('MyCLabs\UnitAPI\Operation\Multiplication', $operation);
    }

    public function testWith()
    {
        $operation = OperationBuilder::addition()
            ->with('m', 2)
            ->getOperation();

        $this->assertEquals(array(new OperationComponent('m', 2)), $operation->getComponents());
    }
}
