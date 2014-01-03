<?php

namespace MyCLabs\UnitAPI\Operation;

/**
 * Unit multiplication.
 *
 * @author matthieu.napoli
 */
class Multiplication extends Operation
{
    /**
     * @return string
     */
    public function __toString()
    {
        return implode(' . ', $this->getComponents());
    }
}
