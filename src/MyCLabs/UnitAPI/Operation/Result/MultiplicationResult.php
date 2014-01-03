<?php

namespace MyCLabs\UnitAPI\Operation\Result;

/**
 * Unit multiplication result.
 *
 * @author matthieu.napoli
 */
class MultiplicationResult extends OperationResult
{
    /**
     * @var float
     */
    private $conversionFactor;

    public function __construct($unitId, $conversionFactor)
    {
        $this->unitId = $unitId;
        $this->conversionFactor = $conversionFactor;
    }

    /**
     * Returns the conversion factor to multiply to the result of the multiplication so that
     * the resulting value is in the correct unit.
     *
     * @return float
     */
    public function getConversionFactor()
    {
        return $this->conversionFactor;
    }
}
