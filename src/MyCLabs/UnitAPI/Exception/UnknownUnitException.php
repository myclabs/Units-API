<?php

namespace MyCLabs\UnitAPI\Exception;

use Exception;

/**
 * The given ID doesn't match any unit.
 *
 * @author matthieu.napoli
 */
class UnknownUnitException extends Exception
{
    /**
     * @var string
     */
    private $unitId;

    public static function create($id)
    {
        $e = new self("Unknown unit $id");
        $e->unitId = $id;

        return $e;
    }

    /**
     * @return string
     */
    public function getUnitId()
    {
        return $this->unitId;
    }
}
