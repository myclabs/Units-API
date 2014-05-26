<?php

namespace MyCLabs\UnitAPI\DTO;

/**
 * Physical quantity.
 *
 * @author matthieu.napoli
 */
class PhysicalQuantityDTO
{
    /**
     * Identifier.
     * @var string
     */
    public $id;

    /**
     * Label.
     * @var TranslatedString
     */
    public $label;

    /**
     * Symbol.
     * @var string
     */
    public $symbol;

    /**
     * ID of the unit of reference of this quantity.
     * @var string
     */
    public $unitOfReference;
}
