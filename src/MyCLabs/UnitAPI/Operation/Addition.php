<?php

namespace MyCLabs\UnitAPI\Operation;

/**
 * Unit addition.
 *
 * @author matthieu.napoli
 */
class Addition extends Operation
{
    /**
     * @return string
     */
    public function __toString()
    {
        return implode(' + ', $this->getComponents());
    }
}
