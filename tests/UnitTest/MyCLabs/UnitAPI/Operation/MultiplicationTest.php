<?php

namespace UnitTest\MyCLabs\UnitAPI\Operation;

use MyCLabs\UnitAPI\Operation\OperationBuilder;

/**
 * @covers \MyCLabs\UnitAPI\Operation\Multiplication
 */
class MultiplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $operation = OperationBuilder::multiplication()
            ->with('m', 1)
            ->with('kg', 2)
            ->with('s', -1)
            ->getOperation();

        $this->assertEquals('m . kg^2 . s^-1', $operation->__toString());
    }
}
