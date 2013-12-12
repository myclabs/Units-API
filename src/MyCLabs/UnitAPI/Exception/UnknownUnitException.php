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

    public function __construct($message, $unitId, $previousException = null)
    {
        parent::__construct($message, 0, $previousException);

        $this->unitId = $unitId;
    }

    public static function create($id)
    {
        return new self("Unknown unit $id", $id);
    }

    /**
     * @return string
     */
    public function getUnitId()
    {
        return $this->unitId;
    }
}
