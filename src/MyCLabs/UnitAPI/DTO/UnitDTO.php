<?php

namespace MyCLabs\UnitAPI\DTO;

/**
 * Unit.
 *
 * @author matthieu.napoli
 */
class UnitDTO
{
    const TYPE_STANDARD = 'standard';
    const TYPE_DISCRETE = 'discrete';
    const TYPE_COMPOSED = 'composed';

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
     * @var TranslatedString
     */
    public $symbol;

    /**
     * Type of the unit
     * @var string
     */
    public $type;

    /**
     * ID of the unit system if any.
     * @var string|null
     */
    public $unitSystem;

    /**
     * ID of the physical quantity if any.
     * @var string|null
     */
    public $physicalQuantity;
}
