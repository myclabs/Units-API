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
    public static function create($id)
    {
        return new self("Unknown unit $id");
    }
}
