<?php

namespace MyCLabs\UnitAPI\Operation;

/**
 * Unit operation component.
 *
 * @author matthieu.napoli
 */
class OperationComponent
{
    /**
     * @var string
     */
    private $unitId;

    /**
     * @var int
     */
    private $exponent;

    /**
     * @param string $unitId
     * @param int    $exponent
     * @throws \InvalidArgumentException Empty unitId given
     */
    public function __construct($unitId, $exponent)
    {
        $this->unitId = (string) $unitId;
        $this->exponent = (int) $exponent;

        if ($this->unitId == '') {
            throw new \InvalidArgumentException(sprintf(
                'The unit ID given for the operation is empty'
            ));
        }
    }

    /**
     * @return string
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * @return int
     */
    public function getExponent()
    {
        return $this->exponent;
    }

    public function __toString()
    {
        if ($this->exponent === 1) {
            return (string) $this->unitId;
        }

        return '(' . $this->unitId . ')^' . $this->exponent;
    }
}
