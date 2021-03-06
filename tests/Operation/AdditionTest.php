<?php

namespace UnitTest\MyCLabs\UnitAPI\Operation;

use MyCLabs\UnitAPI\Operation\OperationBuilder;

/**
 * @covers \MyCLabs\UnitAPI\Operation\Addition
 */
class AdditionTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $operation = OperationBuilder::addition()
            ->with('m', 1)
            ->with('kg^3', 2)
            ->with('s', -1)
            ->getOperation();

        $this->assertEquals('m + (kg^3)^2 + (s)^-1', $operation->__toString());
    }
}
