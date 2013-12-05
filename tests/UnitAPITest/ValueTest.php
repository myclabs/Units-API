<?php

namespace UnitAPITest;

use MyCLabs\UnitAPI\Value;

class ValueTest extends \PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        $value = new Value(10, 'm', 50);

        $this->assertEquals(10, $value->getNumericValue());
        $this->assertEquals('m', $value->getUnit());
        $this->assertEquals(50, $value->getUncertainty());
    }

    /**
     * @dataProvider provideValidExports
     */
    public function testExportImport(Value $value, $exportedValue)
    {
        $this->assertSame($exportedValue, $value->serialize());
        $this->assertEquals($value, Value::unserialize($exportedValue));
    }

    public function provideValidExports()
    {
        return [
            [new Value(10, 'm', 50), '10|m|50'],
            [new Value(10.5, 'm', 5.2), '10.5|m|5.2'],
            [new Value(10, 'm'), '10|m|'],
            [new Value(null, null), '0||'],
            [new Value(10, 'm.s-1', 2), '10|m.s-1|2'],
            [new Value(10, 'm . m', 50), '10|m . m|50'],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The string has an invalid format
     * @dataProvider provideInvalidImports
     */
    public function testInvalidImport($string)
    {
        Value::unserialize($string);
    }

    public function provideInvalidImports()
    {
        return [
            [null],
            [''],
            ['10|m'],
            ['10m|50'],
            ['10|m|50|12'],
            ['||||'],
        ];
    }
}
